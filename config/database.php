<?php

    // Abre Conexão com MySQL (Banco de dados)
    function DBConnect(){
        $link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
        mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));

        return $link;
    }

    // Fechar Conexão com MySQL (Banco de dados)
    function DBClose($link) {
        @mysqli_close($link) or die(mysqli_error($link));
    }

    // Protege contra SQL Injection
    function DBEscape($data) {
        $link = DBConnect();

        if(!is_array($data)) {
            $data = mysqli_real_escape_string($link, $data);
        } else {
            $arr = $data;

            foreach ($arr as $key => $value) {
                $key = DBEscape($key);
                $value = DBEscape($value);

                $data[$key] = $value;
            }
        }

        DBClose($link);
        return $data;
    }

    // Executa Querys
    function DBExecute($query, $insertId = false) {
        $link = DBConnect();
        $result = @mysqli_query($link, $query) or die(mysqli_error($link));

        if($insertId) {
            $result = mysqli_insert_id($link);
        }

        DBClose($link);
        return $result;
    }

    // Ler Registros
    function DBRead($table, $params = null, $fields = '*') {
        $table = $table;
        $params = ($params) ? " {$params}" : null;

        $query = "SELECT {$fields} FROM {$table}{$params}";
        $result = DBExecute($query);

        if(!mysqli_num_rows($result)) {
            return false;
        } else {
            while ($res = mysqli_fetch_assoc($result)) {
                $data[] = $res;
            }

            return $data;
        }
    }

    // Grava Registros
    function DBCreate($table, array $data, $insertId = false) {
        $table = $table;
        $data = DBEscape($data);

        $fields = implode(', ', array_keys($data));
        $values = "'".implode("', '", $data)."'";

        $query = "INSERT INTO {$table} ( {$fields} ) VALUES ( {$values} )";

        return DBExecute($query, $insertId);
    }
    
    // Altera Registros
    function DBUpdate($table, array $data, $where = null, $insertId = false) {
        foreach ($data as $key => $value){
			$fields[] = "{$key} = '{$value}'";
		}

        $fields = implode(', ', $fields);
        $where = ($where) ? " WHERE {$where}" : null;
        $query = "UPDATE {$table} SET {$fields}{$where}";
        return DBExecute($query, $insertId);
    }

    // Deleta Registros
    function DBDelete($table, $where = null) {
        $where = ($where) ? " WHERE {$where}" : null;

        $query = "DELETE FROM {$table}{$where}";
        return DBExecute($query);
    }