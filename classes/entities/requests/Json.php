<?php

namespace sql_links\requests;

use \sql_links\Entities\extended\DatabaseFiles;
use \sql_links\interfaces\IRequest;
use \sql_links\factories\RequestConnexion;
use stdClass;
use Exception;

class Json extends DatabaseFiles implements IRequest
{
	private	$directory_database,
			$request_array = [],
			$last_request_array = [],
			$query_result = [],
			$last_query_result = false;

	private $read = false,
			$write = false;

	/**
	 * @Description : Methods
	 */
	const CREATE = 'CREATE';
	const SHOW = 'SHOW';
	const SELECT = 'SELECT';
	const INSERT = 'INSERT';
	const DELETE = 'DELETE';
	const DROP = 'DROP';
	const UPDATE = 'UPDATE';
	const ALTER = 'ALTER';

	/**
	 * @Description : For like() method
	 */
	const START = 1;
	const END = 2;
	const MIDDLE = 3;

	/**
	 * @Description : logic operators
	 */
	const AND = '&&';
	const OR = '||';

	/**
	 * @Description : For create() method
	 */
	const TABLE = 'table';
	const DATABASE = 'database';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function __construct(RequestConnexion $connexion) {
		$this->directory_database = $connexion->database()[0];

		if(!is_dir($this->directory_database)):
			mkdir($this->directory_database,0777, true);
		endif;
    }

    /**
     * {@inheritdoc}
     */
    function read()
    {
		$this->read = true;
		$this->write = false;
		$this->request_array = [];
    }

    /**
     * {@inheritdoc}
     */
    function write()
    {
        $this->write = true;
        $this->read = false;
        $this->request_array = [];
    }

    /**
     * {@inheritdoc}
     */
    function is_read(): bool
    {
        return $this->read;
    }

    /**
     * {@inheritdoc}
     */
    function is_write(): bool
    {
        return $this->write;
    }

    /**
     * {@inheritdoc}
     */
    function select(array $selected = []): IRequest
    {
    	$this->read();
    	$this->request_array['method'] = self::SELECT;
    	if(empty($selected)) {
    		$selected = '*';
		}
    	$this->request_array['selected'] = $selected;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function insert(): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::INSERT;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function delete(): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::DELETE;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function update(string $table): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::UPDATE;
		$this->request_array['table'] = $table;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function show(): IRequest
    {
		$this->read();
		$this->request_array['method'] = self::SHOW;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function create($type, $name): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::CREATE;
		$this->request_array['selected'] = $type;
		$this->request_array['name_created'] = $name;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function drop($type, $name): IRequest
    {
		$this->read();
		if($this->request_array['method'] == self::ALTER) {
			$this->request_array['action'] = 'drop';
		}
		else {
			$this->request_array['method'] = self::DROP;
			$this->request_array['type'] = $type;
		}
		$this->request_array['name_droped'] = $name;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function alter($table): IRequest
    {
		$this->read();
		$this->request_array['method'] = self::ALTER;
		$this->request_array['table'] = $table;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function tables(): IRequest
    {
        $this->request_array['type'] = 'tables';
        return $this;
    }

	/**
	 * @param array $array
	 * @return IRequest
	 */
	public function add(array $array) {
		$this->request_array['action'] = 'add';
		$this->request_array['set'] = $array;
		return $this;
	}

	/**
	 * @param array $array
	 * @return IRequest
	 */
	public function modify(array $array) {
		$this->request_array['action'] = 'modify';
		$this->request_array['set'] = $array;
		return $this;
	}

	/**
	 * @param array $array
	 * @return IRequest
	 */
	public function change(array $array) {
		$this->request_array['action'] = 'change';
		$this->request_array['set'] = $array;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
    function databases($schemas = false): IRequest
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function columns(): IRequest
    {
        $this->request_array['type'] = 'columns';
    	return $this;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    function into($table): IRequest
    {
		if(is_file($this->directory_database.'/'.$table.'.json')) {
			$this->request_array['table'] = $table;
		}
		else {
			throw new Exception('La table `'.$table.'` n\'existe pas.');
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    function from($table): IRequest
    {
    	if(is_file($this->directory_database.'/'.$table.'.json')) {
			$this->request_array['table'] = $table;
		}
        else {
			throw new Exception('La table `'.$table.'` n\'existe pas.');
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function where($where): IRequest
    {
        $this->request_array['where'] = $where;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function like(array $array, int $place): IRequest
    {
        $this->request_array['like'] = [
        	$array,
			$place
		];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function limit(int $limite, int $offset = 0): IRequest
    {
        $this->request_array['limit'] = $limite;
        if($offset !== 0) {
        	$this->request_array['offset'] = $offset;
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function order_by($comumns): IRequest
    {
        $this->request_array['order_by'] = $comumns;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function group_by($comumns): IRequest
    {
        $this->request_array['group_by'] = $comumns;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function and (): IRequest
    {
        $this->request_array['operator'][] = self::AND;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function or (): IRequest
    {
		$this->request_array['operator'][] = self::OR;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function is_null(): IRequest
    {
        $this->request_array['is_null'] = true;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function is_not_null(): IRequest
    {
        $this->request_array['is_null'] = false;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function on($on): IRequest
    {
        $this->request_array['on'] = $on;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function in(array $array): IRequest
    {
        $this->request_array['in'] = $array;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function set(array $to_set): IRequest
    {
        $this->request_array['set'] = $to_set;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function inner_join($table): IRequest
    {
        $this->request_array['join'] = [
        	'table' => $table
		];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function left_join($table): IRequest
    {
		$this->request_array['join'] = [
			'type' => 'left',
			'table' => $table
		];
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function right_join($table): IRequest
    {
		$this->request_array['join'] = [
			'type' => 'right',
			'table' => $table
		];
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function last_request(): array
    {
		return $this->last_request_array;
    }

    /**
     * {@inheritdoc}
     */
    function request(): array
    {
        return $this->request_array;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    function query()
    {
    	switch ($this->request_array['method']) {
			case self::ALTER	:
				$all_table = $this->read_file($this->directory_database.'/'.$this->request_array['table'].'.json');
				$all_table = $this->decode($all_table);
				$header = $all_table->header;
				if($this->request_array['action'] === 'add') {
					foreach ($this->request_array['set'] as $item => $value) {
						$head = [
							'champ' => $item,
							'type' => $value['type']
						];
						if(isset($value['key'])) {
							$head['key'] = $value['key'];
						}
						if(isset($value['increment'])) {
							$head['autoincrement'] = true;
						}
						else {
							$head['autoincrement'] = false;
						}
						if(isset($value['default'])) {
							$head['default'] = $value['default'];
						}

						$header[] = $head;
					}

					$all_table->header = $header;

					return $this->write_in_file(
						$this->directory_database.'/'.$this->request_array['table'].'.json',
						$this->encode($all_table)
					);
				}
				return false;
			case self::DROP		:
				unlink($this->directory_database.'/'.$this->request_array['name_droped'].'.json');
				if(is_file($this->directory_database.'/'.$this->request_array['name_droped'].'.json')) {
					return false;
				}
				return true;
			case self::CREATE	:
				if($this->request_array['selected'] === self::TABLE) {
					if (!file_exists($this->directory_database.'/'.$this->request_array['name_created'].'.json')) {
						$f = fopen($this->directory_database.'/'.$this->request_array['name_created'].'.json', 'w+');
						$tmp = [];
						foreach ($this->request_array['set'] as $item => $value) {
							$tmp[] = "{ \"champ\": \"{$item}\", \"type\": \"{$value['type']}\"".(isset($value['key']) ? ', "key": "'.$value['key'].'_key"' : '')."".(isset($value['increment']) ? ', "autoincrement": true' : ', "autoincrement": false')."".(isset($value['default']) ? ', "default": "'.$value['default'].'"' : '')." }";
						}

						fwrite($f, '{"header": ['.implode(', ', $tmp).'], "datas": []}');
						fclose($f);
					}
				}
				elseif ($this->request_array['selected'] === self::DATABASE) {
					throw new Exception('Vous utilisez déja une base de données');
				}
				return true;
			case self::INSERT	:
				for($i=0, $max=count($this->request_array['values']); $i<$max; $i++) {

					$all_table = $this->read_file($this->directory_database.'/'.$this->request_array['table'].'.json');
					$all_table = $this->decode($all_table);
					$header = $all_table->header;
					$datas = $all_table->datas;
					$autoincrement = false;
					$autoincrement_exists = false;
					$champ_dispo = [];
					$champ_default = [];

					foreach ($header as $value) {
						$champ_dispo[] = $value->champ;
					}

					foreach ($header as $value) {
						if(isset($value->default)) {
                            /**
                             * @var array $value
                             */
							$champ_default[$value->champ] = $value->default;
						}
					}

					foreach ($header as $value) {
						if($value->autoincrement == true) {
							$autoincrement = $value->champ;
							break;
						}
					}

					foreach ($this->request_array['values'][$i] as $champ => $value) {
						if(!in_array($champ, $champ_dispo)) {
							throw new Exception("Le champ `{$champ}` n'existe pas dans la table `{$this->request_array['table']}` !");
						}
					}

					if (isset($this->request_array['values'][$i][$autoincrement])) {
						if(count($this->request_array['values'][$i]) < count($all_table->header)) {
							if(count($this->request_array['values'][$i])+count($champ_default) < count($all_table->header)) {
								throw new Exception("Il y a des champs manquants par rapport à la table `{$this->request_array['table']}` dans votre requete !".__LINE__);
							}
						}
						foreach ($datas as $data) {
							if ($data->$autoincrement == $this->request_array['values'][$i][$autoincrement]) {
								$autoincrement_exists = true;
								break;
							}
						}
					} else {
						if(count($this->request_array['values'][$i]) < count($all_table->header)-1) {
							if(count($this->request_array['values'][$i])+count($champ_default) < count($all_table->header)-1) {
								throw new Exception("Il y a des champs manquants par rapport à la table `{$this->request_array['table']}` dans votre requete !");
							}
						}
						if (count($datas) == 0) {
							$this->request_array['values'][$i][$autoincrement] = 0;
						} else {
							$this->request_array['values'][$i][$autoincrement] = $datas[count($datas) - 1]->$autoincrement + 1;
						}
					}

					foreach ($champ_default as $item => $default) {
						if(!isset($this->request_array['values'][$i][$item])) {
							$this->request_array['values'][$i][$item] = $default;
						}
					}

					if (!$autoincrement_exists) {
						$data             = $this->request_array['values'][$i];
						$datas[]          = $data;
						$all_table->datas = $datas;
						$this->write_in_file(
							$this->directory_database.'/'.$this->request_array['table'].'.json',
							$this->encode($all_table)
						);
					} else {
						throw new Exception("La clée `{$autoincrement}` doit être unique");
					}
				}

				return true;
			case self::SHOW		:
				$directory = opendir($this->directory_database);
				$tmp = [];
				switch ($this->request_array['type']) {
                    case 'tables':
                        while (($dir = readdir($directory)) !== false) {
                            if($dir != '.' && $dir != '..') {
                                $tmp[] = str_replace('.json', '', $dir);
                            }
                        }
                        break;
                    case 'columns':
                        $champs = json_decode(file_get_contents($this->directory_database.'/'.$this->request_array['table'].'.json'))->header;
                        foreach ($champs as $champ) {
                            $name = $champ->champ;
                            unset($champ->champ);
                            $tmp[$name] = $champ;
                        }
                        break;
                    default:
                        break;
				}

				return $tmp;
			case self::SELECT	:
				$all_table = file_get_contents($this->directory_database.'/'.$this->request_array['table'].'.json');
				$all_table = $this->decode($all_table);
				if($this->request_array['selected'] === '*') {
					if(isset($this->request_array['where'])) {
						$datas = $all_table->datas;
						$tmp = [];
						foreach ($this->request_array['where'] as $item => $value) {
							foreach ($datas as $data) {
								if($data->$item == $value) {
									$obj = new stdClass();
									foreach ($all_table->header as $champ) {
										$champ = $champ->champ;
										if(isset($data->$champ)) {
											$obj->$champ = $data->$champ;
										}
										else {
											throw new Exception("Le champ `{$champ}` n'existe pas dans la table `{$this->request_array['table']}` !");
										}
									}
									$tmp[] = $obj;
								}
							}
						}
						return $tmp;
					}
					return $all_table->datas;
				}
				else {
					$datas = $all_table->datas;
					$tmp = [];
					foreach ($this->request_array['where'] as $item => $value) {
						foreach ($datas as $data) {
							if($data->$item == $value) {
								$obj = new stdClass();
								foreach ($this->request_array['selected'] as $champ => $alias) {
									if(gettype($champ) === 'string') {
										if(isset($data->$champ)) {
											$obj->$alias = $data->$champ;
										}
										else {
											throw new Exception("Le champ `{$champ}` n'existe pas dans la table `{$this->request_array['table']}` !");
										}
									}
									else {
										if(isset($data->$alias)) {
											$obj->$alias = $data->$alias;
										}
										else {
											throw new Exception("Le champ `{$alias}` n'existe pas dans la table `{$this->request_array['table']}` !");
										}
									}
								}
								$tmp[] = $obj;
							}
						}
					}
					return $tmp;
				}
			case self::DELETE	:
                /**
                 * @var array $all_table
                 */
				$all_table = $this->decode($this->read_file(
						$this->directory_database.'/'.$this->request_array['table'].'.json'
					));
				foreach ($this->request_array['where'] as $item => $value) {
					$champ_exists = false;
					foreach ($all_table->header as $header) {
						if($header->champ == $item) {
							$champ_exists = true;
							break;
						}
					}
					if($champ_exists) {
						foreach ($all_table->datas as $i => $data) {
							if($data->$item == $value) {
								unset($all_table->datas[$i]);
							}
						}
                        /**
                         * @var array $all_table
                         */
						$all_table->datas = $this->ordonate_array($all_table->datas);
					}
					else {
						throw new Exception("Le champ `{$item}` n'existe pas !");
					}
				}

				return $this->write_in_file(
					$this->directory_database.'/'.$this->request_array['table'].'.json',
					$this->encode($all_table)
				);
			case self::UPDATE	:
				$all_table = $this->decode($this->read_file($this->directory_database.'/'.$this->request_array['table'].'.json'));
				foreach ($this->request_array['where'] as $item => $value) {
					$champ_exists = false;
					foreach ($all_table->header as $header) {
						if($header->champ == $item) {
							$champ_exists = true;
							break;
						}
					}
					if(!$champ_exists) {
						throw new Exception("Le champ `{$item}` n'existe pas !");
					}
				}
				foreach ($this->request_array['set'] as $item => $value) {
					$champ_exists = false;
					foreach ($all_table->header as $header) {
						if($header->champ == $item) {
							$champ_exists = true;
							break;
						}
					}
					if(!$champ_exists) {
						throw new Exception("Le champ `{$item}` n'existe pas !");
					}
				}
				foreach ($this->request_array['where'] as $item => $value) {
					foreach ($all_table->datas as $i => $data) {
						if($data->$item == $value) {
							foreach ($this->request_array['set'] as $set => $value_set) {
								$all_table->datas[$i]->$set = $value_set;
							}
						}
					}
				}

				return $this->write_in_file(
					$this->directory_database.'/'.$this->request_array['table'].'.json',
					$this->encode($all_table)
				);
			default:
				return false;
		}
    }

    /**
     * {@inheritdoc}
     */
    function values(array $values): IRequest
    {
        $this->request_array['values'] = $values;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function get_last_query_result()
    {
        return $this->last_query_result;
    }

    /**
     * {@inheritdoc}
     */
    function get_query_result(): array
    {
        return $this->query_result;
    }

    /**
     * {@inheritdoc}
     */
    function asc(): IRequest
    {
        $this->request_array['order'] = 'asc';
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function desc(): IRequest
    {
        $this->request_array['order'] = 'desc';
		return $this;
    }
}