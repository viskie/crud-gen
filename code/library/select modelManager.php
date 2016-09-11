function getVariables($arr_post)
					{						
						$fields = $this->view_fields;
						$arr_variable = array();
						foreach($fields as $k=>$v)
						{	
							if(array_key_exists($v,$arr_post))
								$arr_variable[$v] = $arr_post[$v];
						}
						return $arr_variable;		
					}
}?>