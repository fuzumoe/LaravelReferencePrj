'use strict';

var gulp = require('gulp');
var elixir = require('laravel-elixir');
var gutil = require('gulp-util');
var livereload = require('gulp-livereload');

elixir.extend('livereload', function(files) {
    files = files || [];

    if (onWatchTask()) {
        livereload.listen();
        if(files.length > 0) {
            gulp.watch(files).on('change', livereload.changed);
        }
        gulp.on('stop', function() {
            livereload.changed('localhost');
        });
    }

    return this;
});

function onWatchTask() {
    return gutil.env._[0] == 'watch';
}