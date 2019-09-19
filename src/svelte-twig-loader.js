const path = require('path');
const { getOptions, interpolateName } = require("loader-utils");
const { compile, preprocess } = require("svelte/compiler");
const stripRegex = /<script.*>[\s\S]*?<\/script>/ig;

module.exports = function(source, map) {
  this.cacheable();
  const options = Object.assign({}, getOptions(this));
  const callback = this.async();

  if (typeof options.emitFile === 'boolean' && options.emitFile === false) {
    callback(null, source, map);
    return;
  }

  const context = options.context || this.rootContext;
  const compileOptions = {
    filename: this.resourcePath,
    format: "esm",
    generate: "ssr",
  };

  preprocess(source, {
    filename: compileOptions.filename,
  })
    .then(
      processed => {
        if (processed.dependencies && this.addDependency) {
          for (let dependency of processed.dependencies) {
            this.addDependency(dependency);
          }
        }

        let { js, warnings, vars } = compile(
          processed.toString(),
          compileOptions
        );

        const exported = vars.filter(v=>!!v.export_name).map(v => v.export_name);

        const html = processed.code
        .replace(stripRegex, '').trim()
        .replace(/\{(.*)\}/g, (match, p1)=>{
          const name = p1.trim();
          if(exported.includes(name)) return `{{${name}}}`;
          return `{${name}}`;
        })

        vars.forEach(v => {
          if(!v.export_name) return;

          html.replace(/\{\s*\s*\}/)
        })

        warnings.forEach(
          options.onwarn
            ? warning => options.onwarn(warning, handleWarning)
            : console.warn
        );

        // see https://github.com/webpack-contrib/file-loader/blob/master/src/index.js
        const url = interpolateName(
          this,
          options.name || '[name].[ext]',
          {
            context,
            source,
            regExp: options.regExp,
          }
        );

        let outputPath = url;
        if (options.outputPath) {
          if (typeof options.outputPath === 'function') {
            outputPath = options.outputPath(url, this.resourcePath, context);
          } else {
            outputPath = path.posix.join(options.outputPath, url);
          }
        }

        this.emitFile(outputPath, html);

        callback(null, source, map);
      },
      err => callback(err)
    )
    .catch(err => {
      // wrap error to provide correct
      // context when logging to console
      callback(new Error(`${err.name}: ${err.toString()}`));
    });
};
