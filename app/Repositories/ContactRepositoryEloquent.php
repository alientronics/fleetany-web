<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContactRepository;
use App\Entities\Contact;
use Illuminate\Support\Facades\Auth;
use App\Entities\Gps;

class ContactRepositoryEloquent extends BaseRepository implements ContactRepository
{

    protected $rules = [
        'contact_type_id'   => 'required',
        'name'      => 'min:3|required',
        ];

    public function model()
    {
        return Contact::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function results($filters = [])
    {
        $contacts = $this->scopeQuery(function ($query) use ($filters) {
            
            $query = $query->select('contacts.*', 'types.name as contact-type')
                            ->leftJoin('types', 'contacts.contact_type_id', '=', 'types.id');
            
            if (!empty($filters['name'])) {
                $query = $query->where('contacts.name', 'like', '%'.$filters['name'].'%');
            }
            if (!empty($filters['contact-type'])) {
                $query = $query->where('types.name', 'like', '%'.$filters['contact-type'].'%');
            }
            if (!empty($filters['city'])) {
                $query = $query->where('contacts.city', 'like', '%'.$filters['city'].'%');
            }

            $query = $query->where('contacts.company_id', Auth::user()['company_id']);
            if ($filters['sort'] == 'contact_type') {
                $sort = 'types.name';
            } else {
                $sort = 'contacts.'.$filters['sort'];
            }
            $query = $query->orderBy($sort, $filters['order']);
            
            return $query;
        })->paginate($filters['paginate']);
        
        return $contacts;
    }
    
    public function hasReferences($idContact)
    {
        $contact = $this->find($idContact);
        $countReferences = $contact->companies()->count();
        $countReferences += $contact->entries()->count();
        $countReferences += $contact->models()->count();
        $countReferences += $contact->tripsDriver()->count();
        $countReferences += $contact->tripsVendor()->count();
        $countReferences += $contact->users()->count();
        
        if ($countReferences > 0) {
            return true;
        }
        return false;
    }
    
    public static function getContacts($type = null, $optionalChoice = false)
    {
        $contacts = Contact::where('contacts.company_id', Auth::user()['company_id']);
        if (!empty($type)) {
            $contacts = $contacts->join('types', 'contacts.contact_type_id', '=', 'types.id')
                            ->where('types.name', $type);
        }
        $contacts = $contacts->lists('contacts.name', 'contacts.id');

        if ($optionalChoice) {
            $contacts->splice(0, 0, ["" => ""]);
        }
        
        return $contacts;
    }
    
    public function getDriverProfile($idContact)
    {
        $results = Gps::select('speed')
            ->where('driver_id', $idContact)
            ->whereNotNull('speed')
            ->orderBy('id', 'desc')
            ->take(50)
            ->get();
        
        return $results;
    }
}
