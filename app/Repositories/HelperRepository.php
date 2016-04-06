<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Kodeine\Acl\Models\Eloquent\Role;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HelperRepository
{
    public function getFilters($form, $fields, Request $request)
    {
        $filters = $this->getFiltersValues($form, $fields);
        $filters['sort_url'] = $filters;
        unset($filters['sort_url']['sort']);
        
        $paginate = empty($request->session()->get('paginate')) ? 10 : $request->session()->get('paginate');
        $filters['paginate'] = empty($form['paginate']) ? $paginate : $form['paginate'];
        $request->session()->put('paginate', $filters['paginate']);
        
        if (empty($form['sort'])) {
            $filters['sort'] = $fields[0];
            $filters['order'] = 'asc';
        } else {
            $sort = explode("-", $form['sort']);
            $filters['order'] = array_pop($sort);
            $filters['sort'] = implode("-", $sort);
            if (! in_array($filters['sort'], $fields)) {
                $filters['sort'] = $fields[0];
            }
        }
        
        $filters['pagination'] = $filters;
        $filters['pagination']['sort'] = str_replace("_", "-", $filters['sort']) . "-" . $filters['order'];
        unset($filters['pagination']['paginate']);
        unset($filters['pagination']['sort_url']);
        $filters = $this->getFiltersSortUrl($filters, $request);
        $filters['sort'] = str_replace("-", "_", $filters['sort']);

        return $filters;
    }

    private function getFiltersValues($form, $fields)
    {
        $filters = array();
        if (! empty($fields)) {
            foreach ($fields as $value) {
                $filters[$value] = empty($form[str_replace("-", "_", $value)]) ? "" :
                                    $form[str_replace("-", "_", $value)];
            }
        }
        return $filters;
    }

    private function getFiltersSortUrl($filters, Request $request)
    {
        $sortUrl = http_build_query($filters['sort_url']);
        foreach (array_keys($filters['sort_url']) as $key) {
            $url = $request->path() . '?' . $sortUrl . "&sort=" . $key;
            if ($filters['sort'] == $key && $filters['order'] == 'asc') {
                $filters['sort_url'][$key] = $url . "-desc";
                $filters['sort_icon'][$key] = "fa-sort-asc";
            } else {
                $filters['sort_url'][$key] = $url . "-asc";
                $filters['sort_icon'][$key] = "fa-sort";
                if ($filters['sort'] == $key) {
                    $filters['sort_icon'][$key] = "fa-sort-desc";
                }
            }
        }
        return $filters;
    }

    public function getAvailableRoles()
    {
        $role = Role::lists('name', 'id');
        $role = $role->transform(function ($item) {
            return Lang::get('general.' . $item);
        });
        return $role;
    }

    public function getAvailableLanguages()
    {
        $languages = array();
        $directories = File::directories(base_path() . DIRECTORY_SEPARATOR .
                            'resources' . DIRECTORY_SEPARATOR . 'lang');
        
        foreach ($directories as $directory) {
            $lang = explode(DIRECTORY_SEPARATOR, $directory);
            $lang = end($lang);
            $languages[$lang] = Lang::get('general.' . $lang);
        }
        return $languages;
    }

    public function validateRecord($record)
    {
        if (empty($record) || $record->company_id != Auth::user()['company_id']) {
            Redirect::to('/')->with('danger', Lang::get('general.accessdenied'))->send();
        }
    }
    
    public static function moeda($valor, $mask = 'en', $decimal = 2)
    {
        $valor = preg_replace("/[^0-9]/", "", $valor);
        if (strlen($valor) < 3) {
            $valor = str_pad($valor, 3, "0", STR_PAD_LEFT);
        }
        $valor = substr($valor, 0, ($decimal * -1)) . "." . substr($valor, ($decimal * -1));
        if ($mask == 'ptbr') {
            return number_format($valor, $decimal, ',', '.');
        } elseif ($mask == 'en') {
            return number_format($valor, $decimal, '.', '');
        } elseif ($mask == 'url') {
            return preg_replace("/[^0-9]/", "", $valor);
        }
        return preg_replace("/[^0-9]/", "", $valor);
    }
}
