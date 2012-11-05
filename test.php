<?PHP

/**
 * Sortable---> Read both files and then match each product with listings 
 */
 $products = array();  
 $handle = @fopen("products.txt", "r");
	if ($handle) {
		$i=0;
		while (($buffer = fgets($handle, 4096)) !== false) {
			$products[$i] = json_decode($buffer, true);
			$i++;
		}
		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}
	 
		fclose($handle);
	}
  
   $listings = array();  
   $h1 = @fopen("listings.txt", "r");
	if ($h1) {
		$i=0;
		while (($buffer = fgets($h1, 4096)) !== false) {
			$listings[$i] = json_decode($buffer, true);
			$i++;
		}
		if (!feof($h1)) {
			echo "Error: unexpected fgets() fail\n";
		}
	 
		fclose($h1);
	}
	// Write to Out put file
	$out_file = "result.txt";
	$fh = fopen($out_file, 'w') or die("can't open file");

	for ($j=0;$j<count($products);$j++){
		set_time_limit(400);
			$prod = $products[$j];
			$match = array();
			foreach($listings as $obj){
		
					if($prod['manufacturer']==$obj['manufacturer']){
						if(strpos($obj['title'],$prod['model'])){
						$match[] = $obj;		
						unset($obj); // Delete that listing from array
						}
						

					}
					
					
				}
				 
					$result['product_name'] = $prod['product_name'];
 					$result['listings'] = $match;
					fwrite($fh, json_encode($result));
					fwrite($fh, "\n");
					print "<pre>";
					print_r($result);
				
			
	}
	
 
fclose($fh);
	die();	 
		
 	
 ?>