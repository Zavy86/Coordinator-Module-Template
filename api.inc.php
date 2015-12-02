<?php
/* -------------------------------------------------------------------------- *\
|* -[ Module-Template - API ]------------------------------------------------ *|
\* -------------------------------------------------------------------------- */

/**
 * Address object
 *
 * @param mixed $address request id or object
 * @return object address object
 */
function api_moduleTemplate_address($address){
 // get object
 if(is_numeric($address)){$address=$GLOBALS['db']->queryUniqueObject("SELECT * FROM `module-template_addresses` WHERE `id`='".$address."'");}
 if(!$address->id){return FALSE;}
 // check and convert
 $address->firstname=stripslashes($address->firstname);
 $address->lastname=stripslashes($address->lastname);
 // return address object
 return $address;
}

/**
 * Addresses
 *
 * @param string $search search query
 * @param boolean $pagination limit query by page
 * @param string $where additional conditions
 * @return object $results array of address objects, $pagination pagination object, $query executed query
 */
function api_moduleTemplate_addresses($search=NULL,$pagination=FALSE,$where=NULL){
 // definitions
 $return=new stdClass();
 $return->results=array();
 // generate query
 $query_table="`module-template_addresses`";
 // fields
 $query_fields="*";
 // where
 $query_where=$GLOBALS['navigation']->filtersQuery(1);
 // search
 if(strlen($search)>0){
  $query_where.=" AND ";
  $query_where.="( `firstname` LIKE '%".$search."%'";
  $query_where.=" OR `lastname` LIKE '%".$search."%' )";
 }
 // conditions
 if(strlen($where)>0){$query_where="( ".$query_where." ) AND ( ".$where." )";}

 // order
 $query_order=api_queryOrder("`lastname` ASC");
 // pagination
 if($pagination){
  $return->pagination=new str_pagination($query_table,$query_where,$GLOBALS['navigation']->filtersGet());
  // limit
  $query_limit=$return->pagination->queryLimit();
 }
 // build query
 $return->query="SELECT ".$query_fields." FROM ".$query_table." WHERE ".$query_where.$query_order.$query_limit;
 // execute query
 $results=$GLOBALS['db']->query($return->query);
 while($result=$GLOBALS['db']->fetchNextObject($results)){$return->results[$result->id]=api_moduleTemplate_address($result);}
 // return objects
 return $return;
}











?>