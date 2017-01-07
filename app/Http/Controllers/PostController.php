<?php
/**
 * Author: Tom Abao
 * Github: https://github.com/kormin
 * Email: abaotom14@gmail.com
 * Description: 
 * Created On: December 12, 2016
 * Additional Comments: 

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


class PostController extends Controller
{
	// protected $table = 'posts';
	private $postId;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('showpost');
	}

	public function insertPost() {
		return view('createpost');
	}

	public function updatePost($id) {
		$post = $this->readById($id);
		if ($post == null) {
			return view('errors/404');
		}
		// var_dump($post);
		return view('editpost', $post);
	}

	function setPostId($id) {
		$this->postId = $id;
	}

	function getPostId() {
		return $this->postId;
	}

	/**
	 * Gets the post from form
	 * @param Request $request
	 * @return null
	 */
	public function getPost(Request $request) {
		$input = array('title', 'content');

		$messages = [
			$input[0].'.required' => 'Title field is required.',
			$input[1].'.required' => 'Content field is required.',
		];

		$this->validate($request, [
			$input[0] => 'required',
			$input[1] => 'required'
		], $messages);

		$this->create($request->$input[0], $request->$input[1]);
		// return redirect()->action('PostController@index');
	}

	public function editPost(Request $request) {
		$input = array('title', 'content');


	}

	public function getUserId() {
		$id = 1;
		return $id;
	}

	public function getPostTypeId() {
		$id = 1;
		return $id;
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

	public function read() {
		$allres = DB::table($table)->get();
		return $allres;
	}

	public function readById($id) {
		// $post = DB::table()->where('picname', $picname)->first();
		// $post = App\Models\Post::find($id);
		$post = Post::find($id);
		return $post;
	}

	public function update($postid, $title, $content) {
		// $updated = $this->getTime();
		// $arr = ['title' => $title, 'content' => $content, 'updated_at' => $updated];
		// DB::table($table)->where('id', $id)->update($arr);
		$post = Post::find($postid);
		$post->$title = $title;
		$post->$content = $content;
		$post->save();
	}

	public function delete($postid) {
		// DB::table($table)->where('id', $id)->delete();
		Post::destroy($postid);
	}
}
