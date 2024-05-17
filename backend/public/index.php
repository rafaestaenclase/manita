<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

require_once './../config/database.php';
require_once './Routing.php';
require_once './../src/controllers/UserController.php';

$data = json_decode(file_get_contents('php://input'));

$router = new Router();

$router->add('/',function(){
  echo json_encode("No function");
});

$router->add('createUser','UsersController@createUser');
$router->add('loginUser','UsersController@loginUser');
$router->add('isLogged','UsersController@isLogged');
$router->add('getUserById','UsersController@getUserById');
$router->add('searchUserByName','UsersController@searchUserByName');
$router->add('updateLastUploadDate','UsersController@updateLastUploadDate');
$router->add('updateLastNotification','UsersController@updateLastNotification');
$router->add('deleteUser','UsersController@deleteUser');



$router->add('getFollowCountByUserId','FollowsController@getFollowCountByUserId');
$router->add('imFollowing','FollowsController@imFollowing');
$router->add('toggleFollowState','FollowsController@toggleFollowState');
$router->add('getFollowsForUser','FollowsController@getFollowsForUser');
$router->add('getFollowedForUser','FollowsController@getFollowedForUser');

$router->add('getPostById','PostsController@getPostById');
$router->add('uploadPost','PostsController@uploadPost');
$router->add('deletePost','PostsController@deletePost');

$router->add('uploadUserAvatar','PostsController@uploadUserAvatar');

$router->add('getLikesCount','LikesController@getLikesCount');
$router->add('toggleLikeState','LikesController@toggleLikeState');
$router->add('getIsLiked','LikesController@getIsLiked');
$router->add('getLikesForUser','LikesController@getLikesForUser');


$router->add('getFollowingRank','ViewsController@getFollowingRank');
$router->add('forYouPosts','ViewsController@forYouPosts');
$router->add('followingPosts','ViewsController@followingPosts');
$router->add('profilePosts','ViewsController@profilePosts');
$router->add('likesForUser','ViewsController@likesForUser');
$router->add('followsForUser','ViewsController@followsForUser');


if ($data != null) {
  $router->run($data->uri);
}


?>