# TATE AND LYLE

Below are instructions on how to setup the tateandlyle theme.

- [Prerequisites](#prerequisites)
- [Compiling theme](#compile)
- [Overrides](#overrides)
- [Notes to consider](#notes)

## Prerequisites(#prerequisites)
- You must understand the basic concept of using the [Sass] CSS pre-processor.
- You need to have `node` installed in your machine. If you don't have it installed
run `sudo apt-get install nodejs`
- Once you have the `node` in your machine, you can run `npm install` to install all the requirements for the theme.

## Compiling theme {#compile}
- To compile the theme for your dev environment, you can run `gulp watch`
- To compile the theme for your production environment, run `gulp prod`

## Overrides {#overrides}
The `./tateandlyle/sass/variables/_override-variables.scss` file is generally where you will
spend the majority of your time providing any default variables that should be
used by the [Bootstrap Framework] instead of its own.

The `./tateandlyle/sass/variables/_override-variables.scss` file contains various Drupal overrides to
properly integrate with the [Bootstrap Framework]. It may contain a few
enhancements, feel free to edit this file as you see fit.

The `./tateandlyle/scss/style.scss` file is the glue that combines:
`_override-variables.scss`, [Bootstrap Framework Source Files] and other sass
files together. Generally, you will not need to modify this
file unless you need to add or remove files to be imported. This is the file
wher it should compile to `./tateandlyle/build/main.css`.

## Notes to consider {#notes}
- Tate and Lyle theme uses `gulpStylelint` and `eslint` to maintain the coding standards.
- Ensure all the `gulpStylelint` and `eslint` errors are fixed before pushing the code to the
production environment.
