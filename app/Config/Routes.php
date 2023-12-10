<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Administrator::index');

$routes->get('/', 'UserManagement::allAdmin');

$routes->get('user_management/user', 'UserManagement::allUser');

$routes->post('user_management/admin/get_data', 'UserManagement::getData');
$routes->get('user_management/admin/add_user', 'UserManagement::add_admin_view');
$routes->post('user_management/add_admin', 'UserManagement::add_admin');
$routes->post('user_management/getAdminUser', 'UserManagement::getAdminUser');

$routes->post('user_management/admin/change_password', 'UserManagement::changeAdminPassword');
$routes->post('user_management/admin/block_user', 'UserManagement::blockAdminUser');
$routes->post('user_management/admin/unblock_user', 'UserManagement::unblockAdminUser');
$routes->post('user_management/admin/delete_user', 'UserManagement::deleteAdminUser');

$routes->post('user_management/user/block_user', 'UserManagement::blockUser');
$routes->post('user_management/user/unblock_user', 'UserManagement::unblockUser');
$routes->post('user_management/user/delete_user', 'UserManagement::deleteUser');

$routes->group('review_feedback', function ($routes) {
    $routes->get('report', 'Report::allReportView');
    $routes->get('report/delete_report/(:segment)', 'Report::deleteReport/$1');
});

$routes->group('notification_marketing', function ($routes) {
    $routes->get('notification', 'Notification::sendNotificationView');
    $routes->post('notification/send_notification', 'Notification::sendNotification');
});

$routes->group('ads_management', function ($routes) {
    $routes->get('report_revenue', 'ReportRevenue::reportRevenueView');
    $routes->post('report_revenue/get_report_revenue', 'ReportRevenue::reportRevenue');
    $routes->get('ad_unit', 'AdUnit::adUnitView');
    $routes->post('ad_units', 'AdUnit::adUnits');
    $routes->get('ads/add_ad_unit', 'AdUnit::addAdUnitView');
    $routes->post('ads/add_ad_unit', 'AdUnit::addAdUnit');
    $routes->get('ads/edit_ad_unit/(:segment)', 'AdUnit::editAdUnitView/$1');
    $routes->post('ads/edit_ad_unit/(:segment)', 'AdUnit::editAdUnit/$1');
});

$routes->group('content_management', function ($routes) {
    $routes->get('all_novel', 'ContentManagement::allNovelView');
    $routes->get('content/add_novel', 'ContentManagement::addNovelView');
    $routes->post('content/add_novel', 'ContentManagement::addNovel');
    $routes->get('content/edit_novel/(:segment)', 'ContentManagement::editNovelView/$1');
    $routes->post('content/edit_novel/(:segment)', 'ContentManagement::editNovel/$1');
    $routes->post('content/add_novel', 'ContentManagement::addNovel');
    $routes->post('content/delete_novel', 'ContentManagement::deleteNovel');

    $routes->get('content/chapter/all_chapter/(:segment)', 'NovelChapter::allChapterView/$1');
    $routes->get('content/chapter/add_chapter/(:segment)', 'NovelChapter::addChapterView/$1');
    $routes->post('content/chapter/add_chapter/(:segment)', 'NovelChapter::addChapter/$1');
    $routes->get('content/chapter/edit_chapter/(:segment)', 'NovelChapter::editChapterView/$1');
    $routes->post('content/chapter/edit_chapter/(:segment)/(:segment)', 'NovelChapter::editChapter/$1/$2');
    $routes->post('content/chapter/delete_chapter', 'NovelChapter::deleteChapter');

    $routes->get('content/chapter/page/all_page/(:segment)/(:segment)', 'NovelPage::allPageView/$1/$2');
    $routes->get('content/chapter/page/add_page/(:segment)/(:segment)', 'NovelPage::addPageView/$1/$2');
    $routes->post('content/chapter/page/add_page/(:segment)/(:segment)', 'NovelPage::addPage/$1/$2');
    $routes->get('content/chapter/page/edit_page/(:segment)/(:segment)/(:segment)', 'NovelPage::editPageView/$1/$2/$3');
    $routes->post('content/chapter/page/edit_page/(:segment)/(:segment)/(:segment)', 'NovelPage::editPage/$1/$2/$3');
    $routes->post('content/chapter/page/delete_page', 'NovelPage::deletePage');
    $routes->get('content/chapter/page/view_page/(:segment)', 'NovelPage::viewPage/$1');

    $routes->get('genre', 'Genre::genreView');
    $routes->get('genre/add_genre', 'Genre::addGenreView');
    $routes->get('genre/edit_genre/(:segment)', 'Genre::editGenreView/$1');
    $routes->post('genre/add_genre', 'Genre::addGenre');
    $routes->post('genre/edit_genre/(:segment)', 'Genre::editGenre/$1');
    $routes->post('genre/delete_genre', 'Genre::deleteGenre');

    $routes->get('tag', 'Tag::tagView');
    $routes->get('tag/add_tag', 'Tag::addTagView');
    $routes->get('tag/edit_tag/(:segment)', 'Tag::editTagView/$1');
    $routes->post('tag/add_tag', 'Tag::addTag');
    $routes->post('tag/edit_tag/(:segment)', 'Tag::editTag/$1');
    $routes->post('tag/delete_tag', 'Tag::deleteTag');

    $routes->get('discover', 'Discover::discoverView');
    $routes->get('discover/add_discover', 'Discover::addDiscoverView');
    $routes->post('discover/add_discover', 'Discover::addDiscover');
    $routes->get('discover/edit_discover/(:segment)', 'Discover::editDiscoverView/$1');
    $routes->post('discover/edit_discover/(:segment)', 'Discover::editDiscover/$1');
    $routes->get('discover/add_discover_novel/(:segment)', 'Discover::addDiscoverNovelView/$1');
    $routes->post('discover/add_discover_novel/(:segment)', 'Discover::addDiscoverNovel/$1');
    $routes->get('discover/delete_discover_novel/(:segment)', 'Discover::deleteDiscoverNovel/$1');
    $routes->get('discover/delete_discover/(:segment)', 'Discover::deleteDiscover/$1');
});

$routes->group('admin', function ($routes) {
    $routes->post('login', 'Administrator::login');
    $routes->post('change_password/(:segment)', 'Administrator::changePassword/$1');
    $routes->get('change_password', 'Administrator::changePasswordView');
    $routes->get('logout', 'Administrator::logout');
});

$routes->group('setting', function ($routes) {
    $routes->get('/', 'Setting::settingView');
    $routes->post('update_setting', 'Setting::updateSetting');
});

$routes->group('api', function ($routes) {
    $routes->post('user/add_google_user', 'api\User::addGoogleUser');
    $routes->get('v1/novel/all_novel', 'api\Novel::allNovel');
    $routes->get('v1/novel/search', 'api\Novel::searchNovel');
    $routes->get('v1/novel/searchM', 'api\Novel::searchNovelM');
    $routes->get('v1/novel/detail/(:segment)', 'api\Novel::novel_detail/$1');
    $routes->post('v1/novel/add_review', 'api\Novel::add_review');
    $routes->get('v1/novel/all_chapter', 'api\Novel::all_chapter');
    $routes->get('v1/novel/all_genre', 'api\Novel::all_genre');
    $routes->get('v1/user/user_profile', 'api\User::user_profile');
    $routes->get('v1/privacy_terms', 'api\User::privacy_terms');
    $routes->post('v1/user/update_image', 'api\User::update_image');
    $routes->post('v1/user/send_feedback', 'api\User::send_feedback');
});



