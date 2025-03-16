import gulp from 'gulp';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import cssnano from 'gulp-cssnano';
import less from 'gulp-less';
import autoprefixer from 'gulp-autoprefixer';

// CSS-Task: LESS kompilieren, Präfixe hinzufügen, und minifizieren
export function css() {
  return gulp.src('assets/dev/less/**/*.less')
    .pipe(less()) // Kompiliert LESS zu CSS
    .pipe(autoprefixer()) // Fügt die nötigen CSS-Präfixe hinzu
    .pipe(cssnano()) // Minifiziert das CSS
    .pipe(concat('style.min.css')) // Alle CSS-Dateien zusammenführen
    .pipe(gulp.dest('assets/prod/css')); // Ausgabe in den prod-Ordner
}

// JS-Task: JS-Dateien zusammenführen und minifizieren
export function js() {
  return gulp.src('assets/dev/js/**/*.js')
    .pipe(concat('scripts.min.js')) // Alle JS-Dateien zusammenführen
    .pipe(uglify()) // Minifiziert das JS
    .pipe(gulp.dest('assets/prod/js')); // Ausgabe in den prod-Ordner
}

// Watch-Task: Überwacht Änderungen an LESS- und JS-Dateien und führt die entsprechenden Tasks aus
export function watch() {
  gulp.watch('assets/dev/less/**/*.less', css);
  gulp.watch('assets/dev/js/**/*.js', js);
}

// Standard-Task: Alle Tasks ausführen
export default gulp.series(css, js);
