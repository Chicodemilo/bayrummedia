<?php 
class Items_model extends CI_Model{

	public function get_all($mag, $ed_id){
		$this->db->order_by("paid_item DESC, advertiser ASC");
		return $this->db->get($mag."_edition_".$ed_id)->result_array();
	}


	public function get_ed_data($mag, $ed_id){
		$this->db->where('id', $ed_id);
		$data = $this->db->get($mag)->result_array();
		return $data;
	}


	public function get_totals($mag, $ed_id)
	{
		$data = $this->db->get($mag."_edition_".$ed_id)->result_array();

		$page_total = 0;
		$sold_total = 0;
		// print_r($data);
		foreach ($data as $value) {
			$page_total += $value['item_size'];
			$sold_total += $value['price'];
		}

		$totals = array('page_total' => $page_total, 'sold_total' => $sold_total);

		$this->db->where('id', $ed_id);
		$this->db->update($mag, $totals);
	}

	public function get_ed_totals($mag, $ed_id)
	{
		$paid_page_total = 0;
		$sold_total = 0;
		$item_count = 0;
		$this->db->where('paid_item', 'Y');
		$data = $this->db->get($mag."_edition_".$ed_id)->result_array();
		foreach ($data as $item) {
			$paid_page_total += $item['item_size'];
			$sold_total += $item['price'];
			$item_count += 1;
			// $sold_total += $item['price'];
		}

		if($item_count == 0){
			$average_size = 0;
			$average_price = 0;
		}else{
			$average_size = $paid_page_total / $item_count;
			$average_size = round($average_size, 2);

			$average_price = $sold_total / $item_count;
			$average_price = round($average_price, 2);
		}

		// $this->db->distinct('associated_user');
		$this->db->where('paid_item', 'Y');
		$this->db->select('associated_user');
		$this->db->distinct();
		$query = $this->db->get($mag."_edition_".$ed_id)->result_array();
		// print_r($query);
		$individual_sales_totals = array();
		foreach ($query as $salesperson) {
			$this->db->where('associated_user', $salesperson['associated_user']);
			$individual_sales = $this->db->get($mag."_edition_".$ed_id)->result_array();
			$individual_total = 0;
			$count = 0;
			foreach ($individual_sales as $price) {
				$individual_total += $price['price'];
				$count += 1;
			}
			$individual_average = $individual_total / $count;
			$individual_average = round($individual_average, 2);
			$id = $salesperson['associated_user'];

			$individual_sales_totals[$id]['total_sales'] = $individual_total;
			$individual_sales_totals[$id]['sales_ave'] = $individual_average;
			$individual_sales_totals[$id]['total_items'] = $count;
		}

		$all_items = $this->db->get($mag."_edition_".$ed_id)->result_array();
		$all_items_total = count($all_items);

		$this->db->where('status', 'WORK');
		$query = $this->db->get($mag."_edition_".$ed_id)->result_array();
		$need_work_total = count($query);

		$this->db->where('status', 'WAIT');
		$query = $this->db->get($mag."_edition_".$ed_id)->result_array();
		$wait_total = count($query);

		$this->db->where('status', 'DONE');
		$query = $this->db->get($mag."_edition_".$ed_id)->result_array();
		$done_total = count($query);


		$totals = array('wait_total' => $wait_total, 'done_total' => $done_total,  'all_items_total' => $all_items_total, 'need_work_total' => $need_work_total, 'ave_size' => $average_size, 'paid_page_total' => $paid_page_total, 'average_price' => $average_price, 'individual_sales_totals' => $individual_sales_totals);
		return $totals;


	}

	//RETURNS THE LIFESPAN OF A MAGAZINE
	public function get_mag_lifespan($mag){
		$this->db->where('short_name', $mag);
		$query = $this->db->get('magazines' );
	}

}
























 ?>