<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ModelRepository;
use App\Entities\Model;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_decode;

class ModelRepositoryEloquent extends BaseRepository implements ModelRepository
{

    protected $rules = [
        'model_type_id'   => 'required',
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return Model::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = [])
    {
        $models = $this->scopeQuery(function ($query) use ($filters) {

            $query = $query->select(
                'models.*',
                'types.name as model-type',
                'contacts.name as vendor'
            );
            $query = $query->leftJoin('types', 'models.model_type_id', '=', 'types.id');
            $query = $query->leftJoin('contacts', 'models.vendor_id', '=', 'contacts.id');
            
            if (!empty($filters['model-type'])) {
                $query = $query->where('types.name', 'like', '%'.$filters['model-type'].'%');
            }
            if (!empty($filters['vendor'])) {
                $query = $query->where('contacts.name', 'like', '%'.$filters['vendor'].'%');
            }
            if (!empty($filters['name'])) {
                $query = $query->where('models.name', 'like', '%'.$filters['name'].'%');
            }

            $query = $query->where('models.company_id', Auth::user()['company_id']);
            if ($filters['sort'] == 'model_type') {
                $sort = 'types.name';
            } elseif ($filters['sort'] == 'vendor') {
                $sort = 'contacts.name';
            } else {
                $sort = 'models.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $models;
    }
    
    public function hasReferences($idModel)
    {
        $model = $this->find($idModel);
        $countReferences = $model->vehicles()->count();
        
        if ($countReferences > 0) {
            return true;
        }
        return false;
    }
    
    public static function getModels($entity_key = null, $idType = null)
    {
        $models = Model::join('types', 'models.model_type_id', '=', 'types.id')
                        ->where('models.company_id', Auth::user()['company_id']);

        if (!empty($entity_key)) {
            $models = $models->where('types.entity_key', $entity_key);
        }

        if (!empty($idType)) {
            $models = $models->where('types.id', $idType);
        }
        
        $models = $models->lists('models.name', 'models.id');
        
        return $models;
    }
    
    public function setInputs($inputs)
    {
        $inputs['map'] = "";
        if (!empty($inputs['tires_fillable'])) {
            $inputs['tires_fillable'] = json_decode($inputs['tires_fillable']);
            unset($inputs['tires_fillable'][0]);
            $inputs['map'] = "";
            foreach ($inputs['tires_fillable'] as $fillable) {
                $inputs['map'] .= $fillable === 1 || $fillable === "1" ? 1 : 0;
            }
        }
        
        $inputs['map'] = str_pad($inputs['map'], 24, "0", STR_PAD_RIGHT);
        
        return $inputs;
    }
    
    public static function getDialogStoreOptions($entity_key = null)
    {
        $options['entity_key'] = $entity_key;
        $options['model_types'] = TypeRepositoryEloquent::getTypes();
        $options['vendors'] = ContactRepositoryEloquent::getContacts();
        
        return $options;
    }
}
