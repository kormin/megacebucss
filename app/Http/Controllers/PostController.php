<?php
/**
 * Author: Tom Abao
 * Github: https://github.com/kormin
 * Email: abaotom14@gmail.com
 * Description: 
 * Created On: December 12, 2016
 * Additional Comments: 
getPostTypeId() currently static
Values Columns:
post_type
user_type
--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_type_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

 */

namespace App\Http\Controllers;

use App\Models\Post as Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
	// protected $table = 'posts';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// $posts = Post::all();
		$posts = $this->read();
		$userid = $this->getUserId();
		// $name = $this->readUserName($userid);
		// echo !is_null($posts);
		return view('posts.showposts', ['posts' => $posts, 'userid' => $userid]);
		// $page = $posts->simplePaginate(1);
	}

	/**
	 * Show the individual post
	 * @param $postid
	 * @return \Illuminate\Http\Response
	 */
	public function showPost($postid) {
		$post = $this->readUserPost($postid);
		$userid = $this->getUserId();
		return view('posts.showpost', ['post' => $post, 'userid' => $userid]);
	}

	/**
	 * Gets the user id
	 *
	 * @return $userid
	 */
	public function getUserId() {
		$userid = Auth::user()->id;
		return $userid;
	}

	/**
	 * Gets the post id
	 *
	 * @return $postid
	 */
	public function getPostTypeId() {
		$posttypeid = 1;
		return $posttypeid;
	}

	public function showMyPosts() {
		$userid = $this->getUserId();
		$posts = $this->readByUserId($userid);
		// $users = DB::table('users')->get();
		// var_dump($posts);
		return view('posts.showmyposts', ['posts' => $posts]);
	}

	public function insertPost() {
		return view('posts.createpost');
	}

	public function updatePost($postid, $userid) {
		// add check if user_id == user's id; if not, no edit allowed
		if ($userid != $this->getUserId()) {
			return view('errors.404');
		}
		$post = $this->readByPostId($postid);
		if ($post == null) {
			return view('errors.404');
		}
		// var_dump($post);
		return view('posts.editpost', $post);

		// try {
		// 	$post = Post::findOrFail($postid);
			// return view('posts.editpost', $post);
		// } catch(Exception $e) {
		// 	return view('errors.404');
		// 	// abort(404,"Research ID not Found!");
		// }
	}

	/**
	 * Deletes post from table
	 * @param null
	 * @return null
	 */
	public function deletePost($postid, $userid) {
		if ($userid != $this->getUserId()) {
			return view('errors.404');
		}
		$this->delete($postid);
		return redirect()->action('PostController@index');
	}

	/**
	 * Gets array of user inputs
	 * @param null
	 * @return userInputs
	 */
	public function userInputs() {
		return array('title', 'content');
	}

	/**
	 * Gets the post from form and inserts to posts table
	 * @param Request $request
	 * @return null
	 */
	public function getPost(Request $request) {
		$input = $this->userInputs();

		$messages = [
			$input[0].'.required' => 'Title field is required.',
			$input[1].'.required' => 'Content field is required.',
		];

		$this->validate($request, [
			$input[0] => 'required',
			$input[1] => 'required'
		], $messages);

		$this->create($request->$input[0], $request->$input[1]);
		return redirect()->action('PostController@index');
	}

	/**
	 * Gets the post from form and edits to posts table
	 * @param Request $request
	 * @return null
	 */
	public function editPost(Request $request, $postid, $userid) {
		if ($userid != $this->getUserId()) {
			return view('errors.404');
		}
		$inputvals = $this->userInputs();
		$input = array($inputvals[0] => $request->title, $inputvals[1] => $request->content);
		// remove null values
		$input = array_filter($input, 'strlen');
		// var_dump($input);
		$this->update($postid, $input);
		return redirect()->action('PostController@index');
	}

	public function create($title, $content) {
		$userid = $this->getUserId();
		$posttypeid = $this->getPostTypeId();
		// $arr = ['title' => $title, 'content' => $content, 
		// 'created_at' => $created, 'updated_at' => $updated,
		// 'user_id' => $userid, 'post_type_id' => $posttypeid];
		// var_dump($arr);
		// DB::table($table)->insert($arr);

		$post = new Post;
		$post->title = $title;
		$post->content = $content;
		$post->user_id = $userid;
		$post->post_type_id = $posttypeid;
		$post->save();
	}

	public function readUserName($userid) {
		$uname = DB::table('users')->where('id', $userid)->value('name');
		return $uname;
	}

	public function read() {
		// SELECT `posts`.`id`,`posts`.`title`,`posts`.`content`,`posts`.`user_id`,`users`.`name` FROM `users` JOIN `posts` ON `users`.`id` = `posts`.`user_id`
		$res = DB::select("SELECT `posts`.`id`,`posts`.`title`,`posts`.`content`,`posts`.`user_id`,`users`.`name` FROM `users` JOIN `posts` ON `users`.`id` = `posts`.`user_id`");
		return $res;
	}

	public function readUserPost($postid) {
		$res = DB::select("SELECT `posts`.`id`,`posts`.`title`,`posts`.`content`,`posts`.`user_id`,`users`.`name` FROM `users` JOIN `posts` ON `users`.`id` = `posts`.`user_id` WHERE `posts`.`id` = :id", ['id' => $postid]);
		return $res;
	}

	public function readByPostId($postid) {
		// $post = DB::table()->where('picname', $picname)->first();
		// $post = App\Models\Post::find($postid);
		$post = Post::find($postid);
		return $post;
	}

	public function readByUserId($userid) {
		$posts = Post::where('user_id', $userid)->get();
		return $posts;
	}

	/**
	 * Updates a post from postid
	 * $postvals = ['tablename' => value, ...]
	 * @param $postid, $postvals
	 * @return null
	 */
	public function update($postid, $postvals) {
		$post = $this->readByPostId($postid);
		foreach ($postvals as $k => $v) {
			$post->$k = $v;
		}
		$post->save();
	}

	public function updateTitle($postid, $title) {
		$post = $this->readByPostId($postid);
		$post->$title = $title;
		$post->save();
	}

	public function updateContent($postid, $content) {
		$post = $this->readByPostId($postid);
		$post->$content = $content;
		$post->save();
	}

	public function updateAll($postid, $title, $content) {
		// $updated = $this->getTime();
		// $arr = ['title' => $title, 'content' => $content, 'updated_at' => $updated];
		// DB::table($table)->where('id', $vid)->update($arr);
		$post = $this->readByPostId($postid);
		$post->$title = $title;
		$post->$content = $content;
		$post->save();
	}

	public function delete($postid) {
		// DB::table($table)->where('id', $vid)->delete();
		Post::destroy($postid);
	}
}
