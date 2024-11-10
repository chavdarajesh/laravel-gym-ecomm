<?php


use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\NewsletterMailController as AdminNewsletterMailController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\SizeController as AdminSizeController;
use App\Http\Controllers\Admin\FlavorController as AdminFlavorController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductSliderController as AdminProductSliderController;
use App\Http\Controllers\Admin\TopSellingProductController as AdminTopSellingProductController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;

use App\Http\Controllers\Front\ContactController as FrontContactController;
use App\Http\Controllers\Front\PagesController as FrontPagesController;
use App\Http\Controllers\Front\ProductController as FrontProductController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('front.home');

Auth::routes();


// Admin Auth Route start
Route::get('/admin/login', [AdminAuthController::class, 'loginGet'])->name('admin.login.get');
Route::post('/admin/login/save', [AdminAuthController::class, 'loginSave'])->name('admin.login.save');

Route::get('/admin/password/forgot', [AdminAuthController::class, 'passwordForgotGet'])->name('admin.password.forgot.get');
Route::post('admin/password/forgot/save', [AdminAuthController::class, 'passwordForgotSave'])->name('admin.password.forgot.save');

Route::get('/admin/password/reset/{token}', [AdminAuthController::class, 'passwordResetGet'])->name('admin.password.reset.get');
Route::post('/admin/password/reset/save', [AdminAuthController::class, 'passwordResetSave'])->name('admin.password.reset.save');
// Admin Auth Route end

// Admin route start
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['is_auth', 'is_user_active', 'is_user_verified', 'is_admin']], function () {

    // dashboard route start
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    // dashboard route end

    // profile setting Modlue start
    Route::get('/profile/setting/password', [AdminProfileController::class, 'profileSettingsPasswordIndex'])->name('admin.profile.settings.password.index');
    Route::post('/profile/setting/password/save', [AdminProfileController::class, 'profileSettingsPasswordSave'])->name('admin.profile.settings.password.save');

    Route::get('/profile/setting', [AdminProfileController::class, 'profileSettingIndex'])->name('admin.profile.setting.index');
    Route::post('/profil/esetting/save', [AdminProfileController::class, 'profileSettingSave'])->name('admin.profile.setting.save');
    // profile setting Modlue end

    // contact us msg Modlue start
    Route::get('/contact/messages', [AdminContactController::class, 'index'])->name('admin.contact.messages.index');
    Route::get('/contact/messages/view/{id}', [AdminContactController::class, 'view'])->name('admin.contact.messages.view');
    Route::post('/contact/messages/delete/{id}', [AdminContactController::class, 'delete'])->name('admin.contact.messages.delete');
    // contact us msg Modlue end

    // contact settings Modlue start
    Route::get('/contact/settings', [AdminContactController::class, 'indexContactSettings'])->name('admin.contact.settings.index');
    Route::post('/contact/settings/save', [AdminContactController::class, 'saveContactSettings'])->name('admin.contact.settings.save');
    // contact settings Modlue end

    // site settings Modlue start
    Route::get('/site/settings', [AdminSiteSettingController::class, 'index'])->name('admin.site.settings.index');
    Route::post('/site/settings/save', [AdminSiteSettingController::class, 'save'])->name('admin.site.settings.save');
    // site settings Modlue end

    // User Modlue start
    Route::any('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/save', [AdminUserController::class, 'save'])->name('admin.users.save');
    Route::get('/users/view/{id}', [AdminUserController::class, 'view'])->name('admin.users.view');
    Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::post('/users/status/toggle', [AdminUserController::class, 'statusToggle'])->name('admin.users.status.toggle');
    Route::post('/users/verify/toggle', [AdminUserController::class, 'verifyToggle'])->name('admin.users.verify.toggle');
    Route::post('/users/delete/{id}', [AdminUserController::class, 'delete'])->name('admin.users.delete');
    Route::get('/users/referrals/{id}', [AdminUserController::class, 'userReferrals'])->name('admin.users.referrals');
    // User Modlue end

    // Blogs Modlue start
    Route::any('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs/save', [AdminBlogController::class, 'save'])->name('admin.blogs.save');
    Route::get('/blogs/view/{id}', [AdminBlogController::class, 'view'])->name('admin.blogs.view');
    Route::get('/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/update', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::post('/blogs/status/toggle', [AdminBlogController::class, 'statusToggle'])->name('admin.blogs.status.toggle');
    Route::post('/blogs/delete/{id}', [AdminBlogController::class, 'delete'])->name('admin.blogs.delete');
    Route::post('/blogs/delete-tag', [AdminBlogController::class, 'deleteTag'])->name('admin.blogs.delete.tag');


    // contact us msg Modlue start
    Route::get('/newsletters', [AdminNewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::post('/newsletters/delete/{id}', [AdminNewsletterController::class, 'delete'])->name('admin.newsletters.delete');
    Route::post('/newsletters/status/toggle', [AdminNewsletterController::class, 'statusToggle'])->name('admin.newsletters.status.toggle');
    // contact us msg Modlue end

    // newslettermails Modlue start
    Route::any('/newslettermails', [AdminNewsletterMailController::class, 'index'])->name('admin.newslettermails.index');
    Route::get('/newslettermails/create', [AdminNewsletterMailController::class, 'create'])->name('admin.newslettermails.create');
    Route::post('/newslettermails/save', [AdminNewsletterMailController::class, 'save'])->name('admin.newslettermails.save');
    Route::get('/newslettermails/view/{id}', [AdminNewsletterMailController::class, 'view'])->name('admin.newslettermails.view');
    Route::get('/newslettermails/edit/{id}', [AdminNewsletterMailController::class, 'edit'])->name('admin.newslettermails.edit');
    Route::put('/newslettermails/update', [AdminNewsletterMailController::class, 'update'])->name('admin.newslettermails.update');
    Route::post('/newslettermails/delete/{id}', [AdminNewsletterMailController::class, 'delete'])->name('admin.newslettermails.delete');
    Route::get('/newslettermails/sendmail/{id}', [AdminNewsletterMailController::class, 'sendmail'])->name('admin.newslettermails.sendmail');
    // newslettermails Modlue end

    // subcategorys Modlue start
    Route::any('/subcategorys', [AdminSubCategoryController::class, 'index'])->name('admin.subcategorys.index');
    Route::get('/subcategorys/create', [AdminSubCategoryController::class, 'create'])->name('admin.subcategorys.create');
    Route::post('/subcategorys/save', [AdminSubCategoryController::class, 'save'])->name('admin.subcategorys.save');
    Route::get('/subcategorys/view/{id}', [AdminSubCategoryController::class, 'view'])->name('admin.subcategorys.view');
    Route::get('/subcategorys/edit/{id}', [AdminSubCategoryController::class, 'edit'])->name('admin.subcategorys.edit');
    Route::put('/subcategorys/update', [AdminSubCategoryController::class, 'update'])->name('admin.subcategorys.update');
    Route::post('/subcategorys/status/toggle', [AdminSubCategoryController::class, 'statusToggle'])->name('admin.subcategorys.status.toggle');
    Route::post('/subcategorys/delete/{id}', [AdminSubCategoryController::class, 'delete'])->name('admin.subcategorys.delete');

    // categorys Modlue start
    Route::any('/categorys', [AdminCategoryController::class, 'index'])->name('admin.categorys.index');
    Route::get('/categorys/create', [AdminCategoryController::class, 'create'])->name('admin.categorys.create');
    Route::post('/categorys/save', [AdminCategoryController::class, 'save'])->name('admin.categorys.save');
    Route::get('/categorys/view/{id}', [AdminCategoryController::class, 'view'])->name('admin.categorys.view');
    Route::get('/categorys/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.categorys.edit');
    Route::put('/categorys/update', [AdminCategoryController::class, 'update'])->name('admin.categorys.update');
    Route::post('/categorys/status/toggle', [AdminCategoryController::class, 'statusToggle'])->name('admin.categorys.status.toggle');
    Route::post('/categorys/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.categorys.delete');

    // brands Modlue start
    Route::any('/brands', [AdminBrandController::class, 'index'])->name('admin.brands.index');
    Route::get('/brands/create', [AdminBrandController::class, 'create'])->name('admin.brands.create');
    Route::post('/brands/save', [AdminBrandController::class, 'save'])->name('admin.brands.save');
    Route::get('/brands/view/{id}', [AdminBrandController::class, 'view'])->name('admin.brands.view');
    Route::get('/brands/edit/{id}', [AdminBrandController::class, 'edit'])->name('admin.brands.edit');
    Route::put('/brands/update', [AdminBrandController::class, 'update'])->name('admin.brands.update');
    Route::post('/brands/status/toggle', [AdminBrandController::class, 'statusToggle'])->name('admin.brands.status.toggle');
    Route::post('/brands/delete/{id}', [AdminBrandController::class, 'delete'])->name('admin.brands.delete');
    Route::post('/brands/subcategories', [AdminBrandController::class, 'subcategories'])->name('admin.brands.subcategories');

    // sizes Modlue start
    Route::any('/sizes', [AdminSizeController::class, 'index'])->name('admin.sizes.index');
    Route::get('/sizes/create', [AdminSizeController::class, 'create'])->name('admin.sizes.create');
    Route::post('/sizes/save', [AdminSizeController::class, 'save'])->name('admin.sizes.save');
    Route::get('/sizes/view/{id}', [AdminSizeController::class, 'view'])->name('admin.sizes.view');
    Route::get('/sizes/edit/{id}', [AdminSizeController::class, 'edit'])->name('admin.sizes.edit');
    Route::put('/sizes/update', [AdminSizeController::class, 'update'])->name('admin.sizes.update');
    Route::post('/sizes/status/toggle', [AdminSizeController::class, 'statusToggle'])->name('admin.sizes.status.toggle');
    Route::post('/sizes/delete/{id}', [AdminSizeController::class, 'delete'])->name('admin.sizes.delete');
    Route::post('/sizes/subcategories', [AdminSizeController::class, 'subcategories'])->name('admin.sizes.subcategories');

     // flavors Modlue start
     Route::any('/flavors', [AdminFlavorController::class, 'index'])->name('admin.flavors.index');
     Route::get('/flavors/create', [AdminFlavorController::class, 'create'])->name('admin.flavors.create');
     Route::post('/flavors/save', [AdminFlavorController::class, 'save'])->name('admin.flavors.save');
     Route::get('/flavors/view/{id}', [AdminFlavorController::class, 'view'])->name('admin.flavors.view');
     Route::get('/flavors/edit/{id}', [AdminFlavorController::class, 'edit'])->name('admin.flavors.edit');
     Route::put('/flavors/update', [AdminFlavorController::class, 'update'])->name('admin.flavors.update');
     Route::post('/flavors/status/toggle', [AdminFlavorController::class, 'statusToggle'])->name('admin.flavors.status.toggle');
     Route::post('/flavors/delete/{id}', [AdminFlavorController::class, 'delete'])->name('admin.flavors.delete');
     Route::post('/flavors/subcategories', [AdminFlavorController::class, 'subcategories'])->name('admin.flavors.subcategories');

     // products Modlue start
    Route::any('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products/save', [AdminProductController::class, 'save'])->name('admin.products.save');
    Route::get('/products/view/{id}', [AdminProductController::class, 'view'])->name('admin.products.view');
    Route::get('/products/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/update', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::post('/products/status/toggle', [AdminProductController::class, 'statusToggle'])->name('admin.products.status.toggle');
    Route::post('/products/delete/{id}', [AdminProductController::class, 'delete'])->name('admin.products.delete');
    Route::post('/products/categories', [AdminProductController::class, 'categories'])->name('admin.products.categories');
    Route::post('/products/subcategories', [AdminProductController::class, 'subcategories'])->name('admin.products.subcategories');
    Route::post('/products/images/delete', [AdminProductController::class, 'imagesDelete'])->name('admin.products.images.delete');


     // productsliders Modlue start
     Route::any('/productsliders', [AdminProductSliderController::class, 'index'])->name('admin.productsliders.index');
     Route::get('/productsliders/create', [AdminProductSliderController::class, 'create'])->name('admin.productsliders.create');
     Route::post('/productsliders/save', [AdminProductSliderController::class, 'save'])->name('admin.productsliders.save');
     Route::get('/productsliders/view/{id}', [AdminProductSliderController::class, 'view'])->name('admin.productsliders.view');
     Route::get('/productsliders/edit/{id}', [AdminProductSliderController::class, 'edit'])->name('admin.productsliders.edit');
     Route::put('/productsliders/update', [AdminProductSliderController::class, 'update'])->name('admin.productsliders.update');
     Route::post('/productsliders/status/toggle', [AdminProductSliderController::class, 'statusToggle'])->name('admin.productsliders.status.toggle');
     Route::post('/productsliders/delete/{id}', [AdminProductSliderController::class, 'delete'])->name('admin.productsliders.delete');

      // productsliders Modlue start
      Route::any('/productsliders', [AdminProductSliderController::class, 'index'])->name('admin.productsliders.index');
      Route::get('/productsliders/create', [AdminProductSliderController::class, 'create'])->name('admin.productsliders.create');
      Route::post('/productsliders/save', [AdminProductSliderController::class, 'save'])->name('admin.productsliders.save');
      Route::get('/productsliders/view/{id}', [AdminProductSliderController::class, 'view'])->name('admin.productsliders.view');
      Route::get('/productsliders/edit/{id}', [AdminProductSliderController::class, 'edit'])->name('admin.productsliders.edit');
      Route::put('/productsliders/update', [AdminProductSliderController::class, 'update'])->name('admin.productsliders.update');
      Route::post('/productsliders/status/toggle', [AdminProductSliderController::class, 'statusToggle'])->name('admin.productsliders.status.toggle');
      Route::post('/productsliders/delete/{id}', [AdminProductSliderController::class, 'delete'])->name('admin.productsliders.delete');

       // topsellingproducts
    Route::get('/topsellingproducts', [AdminTopSellingProductController::class, 'index'])->name('admin.topsellingproducts.index');
    Route::post('/topsellingproducts/update', [AdminTopSellingProductController::class, 'update'])->name('admin.topsellingproducts.update');

});
// Admin route end

// User Auth Route start
Route::get('/user/login', [AdminAuthController::class, 'loginGet'])->name('user.login.get');
Route::post('/user/login/save', [AdminAuthController::class, 'loginSave'])->name('user.login.save');

Route::get('/user/password/forgot', [AdminAuthController::class, 'passwordForgotGet'])->name('user.password.forgot.get');
Route::post('user/password/forgot/save', [AdminAuthController::class, 'passwordForgotSave'])->name('user.password.forgot.save');

Route::get('/user/password/reset/{token}', [AdminAuthController::class, 'passwordResetGet'])->name('user.password.reset.get');
Route::post('/user/password/reset/save', [AdminAuthController::class, 'passwordResetSave'])->name('user.password.reset.save');
// User Auth Route end

// User route start
Route::group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => ['is_auth', 'is_user_active', 'is_user_verified']], function () {

    // dashboard route start
    Route::get('/', function () {
        return redirect()->route('user.dashboard');
    });
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    // dashboard route end

    // profile setting Modlue start
    Route::get('/profile/setting/password', [UserProfileController::class, 'profileSettingsPasswordIndex'])->name('user.profile.settings.password.index');
    Route::post('/profile/setting/password/save', [UserProfileController::class, 'profileSettingsPasswordSave'])->name('user.profile.settings.password.save');

    Route::get('/profile/setting', [UserProfileController::class, 'profileSettingIndex'])->name('user.profile.setting.index');
    Route::post('/profil/esetting/save', [UserProfileController::class, 'profileSettingSave'])->name('user.profile.setting.save');
    // profile setting Modlue end
});
// User route end

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', [FrontPagesController::class, 'home'])->name('front.home');
Route::get('/about', [FrontPagesController::class, 'about'])->name('front.about');
Route::get('/services', [FrontPagesController::class, 'services'])->name('front.services');

Route::get('/blogs', [FrontPagesController::class, 'blogs'])->name('front.blogs');
Route::get('/blog/details/{id}', [FrontPagesController::class, 'details'])->name('front.blog.details');
Route::get('/blog/tags/{id}', [FrontPagesController::class, 'tagsList'])->name('front.blog.tags.list');
Route::get('/blog/author/{id}', [FrontPagesController::class, 'authorList'])->name('front.blog.autor.list');
Route::get('/blog/search', [FrontPagesController::class, 'search'])->name('front.blog.search');

Route::get('/contact', [FrontContactController::class, 'contact'])->name('front.contact');
Route::post('/contact/message/save', [FrontContactController::class, 'contactMessageSave'])->name('front.contact.message.save');

Route::post('/newsletter/save', [FrontPagesController::class, 'newsletterSave'])->name('front.newsletter.save');
Route::get('/newsletter/unsubscribe/{email}', [FrontPagesController::class, 'newsletterUnSubscribe'])->name('front.newsletter.unsubscribe');

Route::get('/privacy_policy', [FrontPagesController::class, 'privacy_policy'])->name('front.privacy_policy');
Route::get('/term_and_condition', [FrontPagesController::class, 'term_and_condition'])->name('front.term_and_condition');
Route::get('/return_and_refund', [FrontPagesController::class, 'return_and_refund'])->name('front.return_and_refund');

Route::get('/products', [FrontPagesController::class, 'products'])->name('front.products');


Route::get('/products', [FrontProductController::class, 'products'])->name('front.products');
