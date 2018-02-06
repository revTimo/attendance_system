<?php 

class Setting extends AppModel {
	// 初めて登録のとき遅刻時間をデフォルト登録
	public function default_set_latetime ($school_id = null)
	{
		if ($this->save(['school_id' => $school_id]) == false)
		{
			return false;
		}
		return true;
	}
}