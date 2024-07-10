<?php
namespace App\Classes;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Nestedsetbie
{

	protected $params;
	protected $checked;
	protected $data;
	protected $count;
	protected $count_level;
	protected $lft;
	protected $rgt;
	protected $level;

	function __construct($params = NULL)
	{
		$this->params = $params;
		$this->checked = NULL;
		$this->data = NULL;
		$this->count = 0;
		$this->count_level = 0;
		$this->lft = NULL;
		$this->rgt = NULL;
		$this->level = NULL;
	}

	public function Get()
	{
		$result = DB::table($this->params['table'] . ' as tb1')
			->select('tb1.id', 'tb1.name', 'tb1.description', 'tb1.canonical', 'tb1.image', 'tb1.parent_id', 'tb1.lft', 'tb1.rgt', 'tb1.level', 'tb1.order')
			->whereNull('tb1.deleted_at')
			->orderBy('tb1.lft', 'asc')->get()->toArray();
		$this->data = $result;
	}

	public function Set()
	{
		if (isset($this->data) && is_array($this->data)) {
			$arr = NULL;
			foreach ($this->data as $key => $val) {
				$arr[$val->id][$val->parent_id] = 1;
				$arr[$val->parent_id][$val->id] = 1;
			}
			return $arr;
		}
	}

	public function Recursive($start = 0, $arr = NULL)
	{
		$this->lft[$start] = ++$this->count;
		$this->level[$start] = $this->count_level;
		if (isset($arr) && is_array($arr)) {
			foreach ($arr as $key => $val) {
				if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
					$this->count_level++;
					$this->checked[$start][$key] = 1;
					$this->checked[$key][$start] = 1;
					$this->Recursive($key, $arr);
					$this->count_level--;
				}
			}
		}
		$this->rgt[$start] = ++$this->count;
	}

	public function Action()
	{
		if (isset($this->level) && is_array($this->level) && isset($this->lft) && is_array($this->lft) && isset($this->rgt) && is_array($this->rgt)) {
			$data = NULL;
			foreach ($this->level as $key => $val) {
				if ($key == 0)
					continue;
				$data[] = array(
					'id' => $key,
					'level' => $val,
					'lft' => $this->lft[$key],
					'rgt' => $this->rgt[$key],
					'name' => '',
					'canonical' => ''
				);
			}

			if (isset($data) && is_array($data) && count($data)) {
				DB::table($this->params['table'])->upsert($data, 'id', ['level', 'lft', 'rgt']);
			}
		}
	}

	public function Dropdown($param = NULL)
	{
		$this->Get();
		if (isset($this->data) && is_array($this->data)) {
			$temp = NULL;
			$temp[0] = (isset($param['text']) && !empty($param['text'])) ? $param['text'] : '[Root]';
			foreach ($this->data as $key => $val) {
				$temp[$val->id] = str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->name;
			}
			return $temp;
		}
	}


	public function ListCatalogue($param = NULL)
	{
		$this->Get();
		if (isset($this->data) && is_array($this->data)) {
			$temp = [];
			// dd($this->data);
			foreach ($this->data as $key => $val) {
				$temp[$val->id] = [
					'name' => str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->name,
					'description' => $val->description,
					'canonical' => $val->canonical,
					'level' => $val->level,
					'order' => $val->order,
					'parent_id' => $val->parent_id,
					'image' => $val->image
				];
			}
			return $temp;
		}
	}




	public function GetComment()
	{
		$result = DB::table($this->params['table'] . ' as tb1')
			->select('tb1.id', 'tb1.content', 'tb1.parent_id', 'tb1.lft', 'tb1.rgt', 'tb1.level', 'tb1.order', 'tb1.user_id', 'tb1.updated_at', 'users.name', 'users.image')
			->leftJoin('users', 'tb1.user_id', '=', 'users.id')
			->whereNull('tb1.deleted_at')
			->orderBy('tb1.lft', 'asc')->get()->toArray();
		$this->data = $result;
	}
	// Phương thức để xây dựng cây comment từ danh sách phẳng
	public function buildCommentTree($comments)
	{
		$tree = [];
		foreach ($comments as $comment) {
			$comment->children = [];
			$tree[$comment->id] = $comment;
		}

		foreach ($tree as $id => &$comment) {
			if ($comment->parent_id != 0) {
				$tree[$comment->parent_id]->children[] = &$comment;
			}
		}

		return array_filter($tree, function ($comment) {
			return $comment->parent_id == 0;
		});
	}

	// Phương thức để lấy tất cả các comment cùng với các comment con của chúng
	public function getAllCommentsWithChildren()
	{
		$this->GetComment();
		return $this->buildCommentTree($this->data);
	}

	public function GetCommentFirst()
	{
		$result = DB::table($this->params['table'] . ' as tb1')
			->select('tb1.id', 'tb1.content', 'tb1.parent_id', 'tb1.lft', 'tb1.rgt', 'tb1.level', 'tb1.order', 'tb1.user_id', 'tb1.updated_at', 'users.name', 'users.image')
			->leftJoin('users', 'tb1.user_id', '=', 'users.id')
			->whereNull('tb1.deleted_at')
			->orderBy('tb1.id', 'desc')->first();
		return $result;
	}


	public function getCommentIdsAndDescendantIds($commentId)
	{
		$comments = Comment::where('id', $commentId)
			->orWhere('parent_id', $commentId)
			->get();
		return $comments->pluck('id')->toArray();

	}
}
