var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var notify = require('gulp-notify');

gulp.task('test', function() {
    gulp.src('spec/**/*.php')
        .pipe(phpspec('', { 'verbose': 'v', notify: true }))
        .on('error', notify.onError({
            message: "Your tests failed!",
            icon: __dirname + '/fail.png'
        }))
        .pipe(notify({
            title: "Success",
            message: "All tests have returned green!",
            icon: __dirname + '/pass.png'
        }));
});

gulp.task('watch', function() {
    gulp.watch(['spec/**/*.php', 'src/**/*.php'], ['test']);
});

gulp.task('default', ['test', 'watch']);