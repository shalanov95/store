<?php
	namespace scr;
	
	class BaseModel
	{
		private static $link;
		
		public function __construct()
		{
			if (!self::$link) {
				self::$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				mysqli_query(self::$link, "SET NAMES 'utf8'");
			}
		}
		protected function findMany($query)
		{
			$result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
			for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
			
			return $data;
		}
        public function selectQuery($table)
        {
            return $this->findMany("Select * from $table");
        }
	}
