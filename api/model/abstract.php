<?php
	require_once "classes/conexao.php";

	class ClassAbstract {

		/**
		 * Inserir os dados no banco de dados
		 * @param [object] $dados com todas informações a ser inseridas.
		 */
		public static function Inserir($tabela, $dados, $campos) {
			try {
				$count=0;
				$infoCampos = "";
				$infoTags = "";
				foreach ($campos as $k => $v) {
					$infoCampos .= ($count==0) ? $k : ', '.$k;
					$infoTags .= ($count==0) ? ':'.$k : ', :'.$k;
					$count++;
				}
				foreach ($dados as $k => $v) {
					$infoDados[":$k"] = $v;
				}
				$sql = "INSERT INTO $tabela ( $infoCampos ) VALUES ( $infoTags )";

				$op = Conexao::getInstance()->prepare($sql);
				$resultado = $op->execute($infoDados);

				$UltimoRegistro = self::UltimoRegistro($tabela);

				return (object) array(
					"status" => 201,
					"data" => $UltimoRegistro->data
				);
			}
			catch (Exception $e) {
				print "Ocorreu um erro ao tentar inserir esta informação.";
				print_r ($e);
			}
		}

		/**
		 * Editar os dados no banco de dados
		 * @param [object] $dados com todas informações a ser editada.
		 */
		public function Editar($tabela, $dados, $campos) {
			try {
				$count=0;
				$infoUpdate = "";

				foreach ($campos as $k => $v) {
					if($k!="id"):
						$infoUpdate .= ($count==0) ? "$k = :$k" : ", $k = :$k";
						$count++;
					endif;
				}
				foreach ($dados as $k => $v) {
					$infoDados[":$k"] = $v;
					$infoDados2["$k"] = $v;
				}

				$sql = "UPDATE $tabela set $infoUpdate WHERE id = :id";

                $op = Conexao::getInstance()->prepare($sql);		
				$info = $op->execute($infoDados);

				return (object) array(
					"status" => 201,
					"data" => $infoDados2
				);
			}
			catch (Exception $e) {
				print "Ocorreu um erro ao tentar editar essa informação.";
			}
		}

		/**
		 * Deleta um registro
		 * @param [int] $id recebe a id do registro a ser deletado.
		 */
		public static function Deletar($tabela = null, $id = null) {
			try {
				$sql = "DELETE FROM $tabela WHERE id = :id";
				$op = Conexao::getInstance()->prepare($sql);
				$op->bindValue(":id", $id);
				return $op->execute();
			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar deletar esta informação.";
			}
		}

		/**
		 * BuscarPorCOD encontra o registro usando o id
		 * @param [int] $id recebe o id do registro a ser encontrado.
		 */
		public static function BuscarPorCOD($tabela = null, $relation = null, $select = null, $id = null, $cls=true) {
			try {
				if($cls):
					if(is_array($relation)):
						$sql = "SELECT $select FROM $tabela, ".$relation['tabela']." WHERE $tabela.id = :cod AND ".$relation['campo'] ;
          		else:
            		$sql = "SELECT $select FROM $tabela WHERE id = :cod";
               endif;   
            else:
         		$sql = "SELECT * FROM $tabela WHERE id = :cod";
            endif;
 
 				$op = Conexao::getInstance()->prepare($sql);
				$op->bindValue(":cod", $id);
				$op->execute();
				$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar encontrar esse codigo.";
			}
		}

		/**
		 * BuscarTodos os registros
		 */
		public static function BuscarTodos($tabela = null, $relation = null, $select = null) {
			try {                
                if(is_array($relation)):
                    $sql = "SELECT $select FROM $tabela, ".$relation['tabela']." WHERE ".$relation['campo'] ;
                else:
                    $sql = "SELECT $select FROM $tabela";
                endif;

				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$dados = (object) $op->fetchall(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);
			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar buscar todas as informações.";
			}
		}

		/**
		 * Encontra o ultimo registro.
		 */
		public static function UltimoRegistro($tabela) {
			try {
				$sql = "SELECT * FROM $tabela ORDER BY id DESC LIMIT 1 ";
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar encontrar o ultimo registro.";
			}
		}
		
		/**
		 * Executar
		 */
		public static function executar($sql, $fetch) {
			try {
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();			
				switch ($fetch) {
					case 'all':
						return (object) $op->fetchall(PDO::FETCH_ASSOC);
						break;
					case 'one':
						return (object) $op->fetch(PDO::FETCH_ASSOC);
					default:
						return (object) $op->fetchall(PDO::FETCH_ASSOC);
						break;
				}

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
			}
		}
	}
?>