<?php
/*
| Common Trait For All Model
| Written common model functions
| @sanjaykumarwebs
| @dev
*/
namespace App\Http\Traits;

trait ModelScopes{
    /**
     * @param Builder $query
     * @param int    $year
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
	public function scopeStatus($query,$type){
    	return $query->where('status',$type);
    }
    
    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeActiveStatus($query){
        return $query->where('status',1);
    }

    /**
     * @param Builder $query
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeInactiveStatus($query){
        return $query->where('status',0);
    }

    /**
     * @param Builder $query
     * @param string  $keyword
     * @param string  $columnName
     *
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeSearch($query,$keyword,$columnName){
		if(!empty($keyword)){ return $this->where($columnName, 'LIKE', "%{$keyword}%"); }
	}
}

?>