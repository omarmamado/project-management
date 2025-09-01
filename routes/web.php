<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashCategory\CashCategoryController;
use App\Http\Controllers\CashRequest\CashRequestController;
use App\Http\Controllers\Department\DepartmentsController;
use App\Http\Controllers\Employee\AnnualEmployeeEvaluationByGMController;
use App\Http\Controllers\Employee\AnnualEmployeeEvaluationController;
use App\Http\Controllers\Employee\EmployeeEvaluationController;
use App\Http\Controllers\Employee\PassKeyController;
use App\Http\Controllers\Forms\FormsController;
use App\Http\Controllers\IdeaRoadmap\IdeaRoadmapController;
use App\Http\Controllers\Idea\IdeaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Project\ProjectInquiryController;
use App\Http\Controllers\Project\ProjectInquiryPhaseController;
use App\Http\Controllers\Project\ProjectsController;
use App\Http\Controllers\Project\TasksController;
use App\Http\Controllers\Team\TeamController;
use App\Http\Controllers\Tsks\TaskCommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Users\EmployeeProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    $currentUser = Auth::user();                  // جلب المستخدم الحالي
    return view('index', compact('currentUser')); // تمرير المتغير إلى الـ view
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');

Route::get('/logout', [AdminController::class, 'AdminLogoutPage'])->name('admin.logout.page');

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');

    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('update.password');

    /// category
    Route::resource('/company', 'App\Http\Controllers\Company\ComapniesController');
    Route::resource('/department', 'App\Http\Controllers\Department\DepartmentsController');

    Route::resource('/users', 'App\Http\Controllers\UserController');
    Route::get('/get-departments-by-company', [UserController::class, 'getDepartmentsByCompany'])->name('get-departments-by-company');
    Route::get('users/export/', [UserController::class, 'export'])->name('export');
// Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');

    Route::resource('cash_requests', CashRequestController::class);

    Route::put('/cash_requests/{id}/update_status', [CashRequestController::class, 'managerApproval'])->name('cash_requests.update_status');
    Route::get('/cash-requests/approved-by-department-head', [CashRequestController::class, 'approvedByDepartmentHead'])->name('cash_requests.approved_by_department_head');

    Route::put('/cash-requests/{id}/update-status', [CashRequestController::class, 'updateStatus'])->name('cash_requests.update_status');
    Route::get('/cash-requests/approved-by-accounts-head', [CashRequestController::class, 'approvedByAccountsHead'])->name('cash_requests.approved_by_accounts_head');
    Route::put('/cash_requests/{id}/accounts_approval', [CashRequestController::class, 'accountsApproval'])->name('cash_requests.accounts_approval');

// Route::put('/cash_requests/{id}/accounts_approval', [AccountantCashRequestController::class, 'accountsApproval'])->name('cash_requests.accounts_approval');
    Route::resource('team', TeamController::class);
    Route::resource('cash-category', CashCategoryController::class);
    Route::get('/cash-requests/report', [CashRequestController::class, 'report'])->name('cash_requests.report');

    Route::get('/cash-reports/export', [CashRequestController::class, 'export'])->name('cash_reports.export');

////////////////////////////////////////////////////
// HR  Route

    Route::resource('employee-profile', EmployeeProfileController::class);

    Route::get('/alert', [EmployeeProfileController::class, 'alert'])->name('alert');
    Route::post('/addEmploymentContrac', [EmployeeProfileController::class, 'addEmploymentContrac'])->name('addEmploymentContrac');

    Route::resource('employee-evaluation', EmployeeEvaluationController::class);
    Route::get('/get-teams-or-managers/{departmentId}', [DepartmentsController::class, 'getTeamsOrManagers']);
    Route::get('/get-team-managers/{teamId}', [DepartmentsController::class, 'getTeamManagers']);
    Route::resource('pass-key', PassKeyController::class);
    Route::resource('annual-employee-evaluation', AnnualEmployeeEvaluationController::class);
    Route::resource('annual-employee-evaluation_by_gm', AnnualEmployeeEvaluationByGMController::class);

/////////////////////////////////////////// Task  Management Route
    Route::resource('forms', FormsController::class);
    Route::resource('projects', ProjectsController::class);
    Route::post('/projects/{id}/add-users', [ProjectsController::class, 'addUsers'])->name('projects.addUsers');
    Route::resource('task', TasksController::class);
    Route::post('task/{id}/cash-request', [TasksController::class, 'cashRequest'])->name('task.cashRequest');

// web.php
    Route::post('/task-comments', [TaskCommentController::class, 'store'])->name('task-comments.store');
    Route::get('/task-comment/replies/{comment}', [TaskCommentController::class, 'getReplies'])->name('task.comment.replies');

    Route::resource('project_inquiry', ProjectInquiryController::class);

    Route::get('/forms/{id}/fields', [ProjectInquiryController::class, 'getFields']);
    Route::get('/form/{id}/fields', [ProjectInquiryController::class, 'getFieldsedit']);
    Route::get('project_inquiry/{project_inquiry}/phases', [ProjectInquiryPhaseController::class, 'showPhases'])->name('project_inquiry.phases');

    Route::resource('project_inquiry_phase', ProjectInquiryPhaseController::class);
    // Idea Roadmap Routes
    Route::resource('idea-roadmaps', IdeaRoadmapController::class);
    Route::get('idea-roadmaps/{id}/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::post('ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::post('/ideas/{idea}/upload-images', [IdeaController::class, 'uploadImages'])->name('ideas.upload.images');
Route::post('/ideas/{idea}/comments', [IdeaController::class, 'comment'])->name('ideas.comments.comment');
Route::post('/ideas/{idea}/vote-ajax', [IdeaController::class, 'ajaxVote'])->name('ideas.vote.ajax');



    Route::get('/project_inquiry_phase/{phase}/detail', [ProjectInquiryPhaseController::class, 'detail'])->name('project_inquiry_phase.detail');
    Route::get('/project_inquiry_phase/{phase}/assign', [ProjectInquiryPhaseController::class, 'assign'])->name('project_inquiry_phase.assign');
    Route::post('/phases/{id}/approve-or-reject', [ProjectInquiryPhaseController::class, 'approveOrReject'])->name('phases.approveOrReject');
    Route::get('/project_inquiry_phase/{phase}/approveOrRejectdetail', [ProjectInquiryPhaseController::class, 'approveOrRejectdetail'])->name('project_inquiry_phase.approveOrRejectdetail');
    Route::put('/phase/{phase}/assign-users', [ProjectInquiryPhaseController::class, 'assignUsers'])->name('phase.assignUsers');

///////////////////////////////////////////////////////

});
