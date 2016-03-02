<?php

namespace App\Repositories;

use Illuminate\Http\Request;

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
            if (!in_array($filters['sort'], $fields)) {
                $filters['sort'] = $fields[0];
            }
        }
        
        $filters = $this->getFiltersSortUrl($filters, $request);
        $filters['sort'] = str_replace("-", "_", $filters['sort']);

        return $filters;
    }
    
    private function getFiltersValues($form, $fields)
    {
        $filters = array();
        if (!empty($fields)) {
            foreach ($fields as $value) {
                $filters[$value] = empty($form[$value]) ? "" : $form[$value];
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
}
