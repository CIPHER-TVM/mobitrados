const { src, dest, watch, series, parallel } = require('gulp')
const autoprefixer = require('gulp-autoprefixer')
const fileinclude = require('gulp-file-include')
const sourcemaps = require('gulp-sourcemaps')
const liveServer = require('live-server')
const cleanCSS = require('gulp-clean-css')
const concat = require('gulp-concat')
const filter = require('gulp-filter')
const rename = require('gulp-rename')
const uglify = require('gulp-terser')
const clean = require('gulp-clean')
const strip = require('gulp-strip-comments')
const sass = require('gulp-sass')
const all = require('gulp-all')

const dist = 'dist/'
const distJS = `${dist}js/`
const distCSS = `${dist}css/`
const distHTML = `${dist}html/`
const distAJAX = `${dist}ajax/`
const pluginsFolder = 'plugins/'

const requiredJS = [
  'node_modules/jquery/dist/jquery.js',
  'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
  'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
]
const requiredJSmin = [
  'node_modules/jquery/dist/jquery.min.js',
  'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
  'node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js',
]

// Copy plugins from 'node_modules' to 'plugins' folder
function pluginsTask() {
  return all(

    // Swiper
    src(['node_modules/swiper/css/swiper.css', 'node_modules/swiper/css/swiper.min.css']).pipe(dest(`${pluginsFolder}/swiper`)),
    src(['node_modules/swiper/js/swiper.js', 'node_modules/swiper/js/swiper.min.js']).pipe(dest(`${pluginsFolder}/swiper`)),

    // noUiSlider
    src('node_modules/nouislider/distribute/**/*').pipe(dest(`${pluginsFolder}nouislider`)),

    // Noty
    src('node_modules/noty/lib/*.js').pipe(dest(`${pluginsFolder}noty`)),
    src('node_modules/noty/lib/noty.css').pipe(dest(`${pluginsFolder}noty`))
      .pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}noty`)),
    src('node_modules/noty/lib/themes/*.css').pipe(dest(`${pluginsFolder}noty/themes`))
      .pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}noty/themes`)),

    // Card (credit card for checkout)
    src('node_modules/card/dist/**/*').pipe(dest(`${pluginsFolder}card`)),
    src('node_modules/card/dist/jquery.card.js').pipe(uglify()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}card`)),

    // Chart.js
    src('node_modules/chart.js/dist/*.js').pipe(dest(`${pluginsFolder}chart.js`)),

    // jQuery Sparkline
    src(['node_modules/jquery-sparkline/jquery.sparkline.js', 'node_modules/jquery-sparkline/jquery.sparkline.min.js']).pipe(dest(`${pluginsFolder}jquery-sparkline`)),

    // Bootbox
    src('node_modules/bootbox/dist/bootbox.min.js').pipe(dest(`${pluginsFolder}bootbox`)),

    // Sortablejs
    src(['node_modules/sortablejs/Sortable.js', 'node_modules/sortablejs/Sortable.min.js']).pipe(dest(`${pluginsFolder}sortablejs`)),

    // Datatables
    src('node_modules/datatables.net/js/**/*').pipe(dest(`${pluginsFolder}datatables`)),
    src('node_modules/datatables.net-bs4/css/**/*').pipe(dest(`${pluginsFolder}datatables`)),
    src('node_modules/datatables.net-bs4/js/**/*').pipe(dest(`${pluginsFolder}datatables`)),

    // Datatables Responsive
    src('node_modules/datatables.net-responsive/js/**/*').pipe(dest(`${pluginsFolder}datatables`)),
    src('node_modules/datatables.net-responsive-bs4/css/**/*').pipe(dest(`${pluginsFolder}datatables`)),
    src('node_modules/datatables.net-responsive-bs4/js/**/*').pipe(dest(`${pluginsFolder}datatables`)),

    // Concat Datatable bootstrap4 responsive for easy to use
    // ref: https://datatables.net/extensions/responsive/examples/styling/bootstrap4.html
    src([
      'node_modules/datatables.net/js/jquery.dataTables.js',
      'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
      'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
      'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.js'
    ])
      .pipe(concat('jquery.dataTables.bootstrap4.responsive.js'))
      .pipe(dest(`${pluginsFolder}datatables`))
      .pipe(rename('jquery.dataTables.bootstrap4.responsive.min.js'))
      .pipe(uglify())
      .pipe(dest(`${pluginsFolder}datatables`)),

    // jqvmap
    src('node_modules/jqvmap/dist/**/*').pipe(dest(`${pluginsFolder}jqvmap`)),

    // Input Mask
    src(['node_modules/inputmask/dist/jquery.inputmask.bundle.js', 'node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js']).pipe(dest(`${pluginsFolder}inputmask`)),

    // Flatpickr
    src('node_modules/flatpickr/dist/**/*').pipe(dest(`${pluginsFolder}flatpickr`)),

    // Bootstrap-select
    src('node_modules/bootstrap-select/dist/css/**/*').pipe(dest(`${pluginsFolder}bootstrap-select`)),
    src('node_modules/bootstrap-select/dist/js/**/*').pipe(dest(`${pluginsFolder}bootstrap-select`)),

    // Clock Picker
    src('node_modules/clockpicker/dist/**/*').pipe(dest(`${pluginsFolder}clockpicker`)),

    // Bootstrap Touchspin
    src('node_modules/bootstrap-touchspin/dist/*.*').pipe(dest(`${pluginsFolder}bootstrap-touchspin`)),

    // Summernote
    src('node_modules/summernote/dist/**/*').pipe(dest(`${pluginsFolder}summernote`)),

    // Simplemde
    src('node_modules/simplemde/dist/*.{css,js}').pipe(dest(`${pluginsFolder}simplemde`)),

    // Autosize
    src(['node_modules/autosize/dist/autosize.js', 'node_modules/autosize/dist/autosize.min.js']).pipe(dest(`${pluginsFolder}autosize`)),

    // Photoswipe
    src('node_modules/photoswipe/dist/photoswipe.css').pipe(dest(`${pluginsFolder}photoswipe`)).pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}photoswipe`)),
    src('node_modules/photoswipe/dist/default-skin/*.*').pipe(dest(`${pluginsFolder}photoswipe/photoswipe-default-skin`)),
    src('node_modules/photoswipe/dist/default-skin/default-skin.css').pipe(cleanCSS()).pipe(rename({ suffix: '.min' })).pipe(dest(`${pluginsFolder}photoswipe/photoswipe-default-skin`)),
    src('node_modules/photoswipe/dist/*.js').pipe(dest(`${pluginsFolder}photoswipe`)),

    // Bootstrap Color Picker
    src(['node_modules/bootstrap-colorpicker/dist/css/*.css', 'node_modules/bootstrap-colorpicker/dist/js/*.js']).pipe(dest(`${pluginsFolder}bootstrap-colorpicker`)),

    // Fullcalendar
    src([
      'node_modules/@fullcalendar/core/main.css',
      'node_modules/@fullcalendar/core/main.min.css',
      'node_modules/@fullcalendar/core/main.js',
      'node_modules/@fullcalendar/core/main.min.js',
      'node_modules/@fullcalendar/core/locales-all.js',
      'node_modules/@fullcalendar/core/locales-all.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/core`)),
    src([
      'node_modules/@fullcalendar/daygrid/main.css',
      'node_modules/@fullcalendar/daygrid/main.min.css',
      'node_modules/@fullcalendar/daygrid/main.js',
      'node_modules/@fullcalendar/daygrid/main.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/daygrid`)),
    src([
      'node_modules/@fullcalendar/timegrid/main.css',
      'node_modules/@fullcalendar/timegrid/main.min.css',
      'node_modules/@fullcalendar/timegrid/main.js',
      'node_modules/@fullcalendar/timegrid/main.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/timegrid`)),
    src([
      'node_modules/@fullcalendar/list/main.css',
      'node_modules/@fullcalendar/list/main.min.css',
      'node_modules/@fullcalendar/list/main.js',
      'node_modules/@fullcalendar/list/main.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/list`)),
    src([
      'node_modules/@fullcalendar/bootstrap/main.css',
      'node_modules/@fullcalendar/bootstrap/main.min.css',
      'node_modules/@fullcalendar/bootstrap/main.js',
      'node_modules/@fullcalendar/bootstrap/main.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/bootstrap`)),
    src([
      'node_modules/@fullcalendar/interaction/main.js',
      'node_modules/@fullcalendar/interaction/main.min.js',
    ]).pipe(dest(`${pluginsFolder}fullcalendar/interaction`)),

  )
}

function htmlTask() {
  return all(
    src('src/html/*.html').pipe(fileinclude()).pipe(dest(distHTML)),
    src('src/ajax/*.html').pipe(fileinclude()).pipe(dest(distAJAX))
  )
}

function _css(file) {
  return src(`src/scss/${file}.scss`)
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(sourcemaps.write('.'))
    .pipe(dest(distCSS))
    .pipe(cleanCSS({ level: { 1: { specialComments: 0 } } })).pipe(rename({ suffix: '.min' }))
    .pipe(filter(['**', `!${distCSS}${file}.css.min.map`])) // ignore minified sourcemap
    .pipe(dest(distCSS))
}

function cssTask() {
  return all(
    _css('style'),
    _css('sidebar-dark'),
    _css('sidebar-blue'),
    _css('sidebar-cyan'),
    _css('sidebar-gray'),
    _css('sidebar-green'),
    _css('sidebar-pink'),
    _css('sidebar-purple'),
    _css('sidebar-red'),
  )
}

function vendorJsTask() {
  return all(
    src(requiredJS).pipe(concat('vendor.js')).pipe(dest(distJS)),
    src(requiredJSmin).pipe(concat('vendor.min.js')).pipe(strip()).pipe(dest(distJS))
  )
}

function templateJsTask() {
  return src('src/js/*.js')
    .pipe(dest(distJS))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(distJS))
}

function concatJsTask() {
  return all(
    src([
      `${distJS}vendor.js`,
      `${distJS}template.js`
    ])
      .pipe(concat('script.js'))
      .pipe(dest(distJS)),

    src([
      `${distJS}vendor.min.js`,
      `${distJS}template.min.js`
    ])
      .pipe(concat('script.min.js'))
      .pipe(dest(distJS))
  )
}

function cleanJsTask() {
  return src([
    `${distJS}vendor.js`,
    `${distJS}vendor.min.js`,
    `${distJS}template.js`,
    `${distJS}template.min.js`
  ], { read: false })
    .pipe(clean())
}

function jsTask(cb) {
  series(vendorJsTask, templateJsTask, concatJsTask, cleanJsTask)(cb)
}

function serveTask() {
  liveServer.start({
    port: 2020,
    noCssInject: true,
    watch: [
      'dist/css/style.min.css',
      'dist/js/script.min.js',
      'dist/html/*.html',
      'dist/ajax/*.html',
      'docs/*.html'
    ]
  })
  // if you use Windows, and experience random reload issue while using live-server,
  // please open cmd as Administrator, and run the following command
  // "fsutil behavior set disablelastaccess 1" without quotes
  // then restart your computer
  // Ref: https://github.com/nodejs/node/issues/21643
}

function watchTask() {
  watch([
    'src/html/*.html',
    'src/html/include/*.html',
    'src/ajax/*.html'
  ], htmlTask)
  watch('src/scss/**/*.scss', cssTask)
  watch('src/js/*.js', jsTask)
}

function cleanTask() {
  return src([distJS, distCSS, distHTML, distAJAX, pluginsFolder], { read: false, allowEmpty: true })
    .pipe(clean())
}

exports.default = series(cleanTask, pluginsTask, htmlTask, cssTask, jsTask, parallel(serveTask, watchTask))
exports.watch = parallel(serveTask, watchTask)
exports.plugins = pluginsTask