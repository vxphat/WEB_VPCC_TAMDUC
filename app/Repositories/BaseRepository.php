<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }


    public function pagination(
        array $column = ['*'],      //Chỉ định các cột cần chọn từ cơ sở dữ liệu
        array $condition = [],      //Điều kiện để lọc kết quả truy vấn
        int $perPage = 9,           //Số lượng mục hiển thị trên mỗi trang
        array $extend = [],         //Các tham số bổ sung như: Đường dẫn cho các liên kết phân trang...
        array $orderBy = ['id', 'DESC'],        //Chỉ định cột và thứ tự để sắp xếp kết quả
        array $join = [],           //Điều kiện kết nối các bảng liên quan
        array $relations = [],      //Tải trước các mối quan hệ
        array $rawQuery = []        //Sử dụng cho cây phân cấp (Bình luận)

    ) {
        $query = $this->model->select($column);         //khởi tạo truy vấn với các cột được chỉ định
        return $query
            ->keyword($condition['keyword'] ?? null)        //Lọc kết quả dựa trên từ khóa nếu có
            ->publish($condition['publish'] ?? null)
            ->relationCount($relations ?? null)
            ->CustomWhere($condition['where'] ?? null)
            ->customWhereRaw($rawQuery['whereRaw'] ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($extend['groupBy'] ?? null)         //Nhóm kết quả nếu có chỉ định
            ->customOrderBy($orderBy ?? null)           //Sắp xếp kết quả dựa trên cột và thứ tự chỉ định
            ->paginate($perPage)            //Phân trang kết quả
            ->withQueryString()->withPath(env('APP_URL') . $extend['path']);
        //tạo ra URL đầy đủ cho các liên kết phân trang, kết hợp URL gốc của ứng dụng (APP_URL từ tệp .env) với đường dẫn được chỉ định trong $extend['path'].
    }

    public function paginate($perpage)
    {
        $model = $this->model->orderBy('id', 'DESC')->paginate($perpage);
        return $model;
    }


    public function create(array $payload = [])
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }


    public function update(int $id = 0, array $payload = [])
    {
        $model = $this->findById($id);
        $model->fill($payload);
        $model->save();
        return $model;
    }



    public function delete(int $id = 0)
    {
        return $this->findById($id)->delete();
    }


    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = [])
    //Where In giúp lọc các bản ghi dựa trên một tập hợp các giá trị cụ thể cho một cột nào đó. WHERE column IN (value1, value2, value3, ...)
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
        //Tìm các bản ghi mà trường $whereInField có giá trị nằm trong mảng $whereIn, cập nhật thành các giá trị trong mảng $payload
    }



    public function forceDelete(int $id = 0)
    {
        return $this->findById($id)->forceDelete();
    }


    public function all(array $relation = [])
    {
        return $this->model->with($relation)->get();
    }

    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = []
    ) {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
        //Phương thức findOrFail sẽ tìm kiếm một bản ghi với $modelId cung cấp. Nếu không tìm thấy, nó sẽ ném ra một ngoại lệ ModelNotFoundException
    }

    public function findByCondition(
        $condition = [],
        $flag = false,
        $relation = [],
        array $orderBy = ['id', 'desc'],
        array $param = []
    ) {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }

        if (isset($param['whereIn'])) {
            $query->whereIn($param['whereInField'], $param['whereIn']);
        }

        if (isset($param['perpage'])) {
            $query->paginate($param['perpage']);
        }

        $query->with($relation);
        $query->orderBy($orderBy[0], $orderBy[1]);
        return ($flag == false) ? $query->first() : $query->get();
    }

    public function createPivot($model, array $payload = [], string $relation = '')
    {
        return $model->{$relation}()->attach($model->id, $payload);
    }



}
