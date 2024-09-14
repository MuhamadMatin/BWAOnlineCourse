    <?php

    use App\Http\Controllers\CourseController;
    use App\Http\Controllers\CourseQuestionController;
    use App\Http\Controllers\CourseStudentController;
    use App\Http\Controllers\LearningController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\StudentAnswerController;
    use App\Models\StudentAnswer;
    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::prefix('/dashboard')->name('dashboard.')->group(function () {
            // middleware harus didaftarkan terlebih dahulu di app bootstrap
            Route::resource('courses', CourseController::class)->middleware('role:admin|teacher');

            Route::get('/course/question/create/{course}', [CourseQuestionController::class, 'create'])
                ->middleware('role:admin|teacher')
                ->name('course.create.question');

            Route::post('/course/question/save/{course}', [CourseQuestionController::class, 'store'])
                ->middleware('role:admin|teacher')
                ->name('course.create.question.store');

            Route::resource('course_questions', CourseQuestionController::class)
                ->middleware('role:admin|teacher');

            Route::get('/course/students/show/{course}', [CourseStudentController::class, 'index'])
                ->middleware('role:admin|teacher')
                ->name('course.course_student.index');

            Route::get('/course/student/create/{course}', [CourseStudentController::class, 'create'])
                ->middleware('role:admin|teacher')
                ->name('course.course_student.create');

            Route::post('/course/student/create/save/{course}', [CourseStudentController::class, 'store'])
                ->middleware('role:admin|teacher')
                ->name('course.course_student.store');

            Route::get('/learning/finished/{course}', [LearningController::class, 'learning_finished'])
                ->middleware('role:admin|student')
                ->name('learning.finished.course');

            Route::get('/learning/raport/{course}', [LearningController::class, 'learning_raport'])
                ->middleware('role:admin|student')
                ->name('learning.raport.course');

            Route::get('/learning', [LearningController::class, 'index'])
                ->middleware('role:admin|student')
                ->name('learning.index');

            Route::get('/learning/{course}/{question}', [LearningController::class, 'learning'])
                ->middleware('role:admin|student')
                ->name('learning.course');

            Route::post('/learning/{course}/{question}', [StudentAnswerController::class, 'store'])
                ->middleware('role:admin|student')
                ->name('learning.course.answer.store');
        });
    });

    require __DIR__ . '/auth.php';
