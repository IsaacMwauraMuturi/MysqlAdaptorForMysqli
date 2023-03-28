<?php
/**
 * Usage: include this file before calling any mysql_.... function.
 *
 * If your PHP does not have the mysql extention enabled, some of its functions will be defined as stubs for mysqli equivalent functions.
 */
if (!function_exists('mysql_connect')) {
    define('MYSQL_BOTH', MYSQLI_BOTH);
    define('MYSQL_ASSOC', MYSQLI_ASSOC);
    define('MYSQL_NUM', MYSQLI_NUM);

    define('MYSQL_CLIENT_COMPRESS', MYSQLI_CLIENT_COMPRESS);
    define('MYSQL_CLIENT_IGNORE_SPACE', MYSQLI_CLIENT_IGNORE_SPACE);
    define('MYSQL_CLIENT_INTERACTIVE', MYSQLI_CLIENT_INTERACTIVE);
    define('MYSQL_CLIENT_SSL', MYSQLI_CLIENT_SSL);

    function mysql_active_link($link, $store = FALSE)
    {
        static $active_link;
        if ($store) {
            $active_link = $link;
        }
        if ($link) {
            return $link;
        }
        return $active_link;
    }

    function mysql_affected_rows($link_identifier = NULL)
    {
        return mysqli_affected_rows(mysql_active_link($link_identifier));
    }

    function mysql_client_encoding($link_identifier = NULL)
    {
        $r = mysqli_get_charset(mysql_active_link($link_identifier));
        return @$r->charset;
    }

    function mysql_close($link_identifier = NULL)
    {
        $link_identifier = mysql_active_link($link_identifier);
        if ($link_identifier === mysql_active_link(NULL)) {
            mysql_active_link(NULL, TRUE);
        }
        return mysqli_close($link_identifier);
    }

    function mysql_connect($server, $username, $password, $new_link = FALSE, $client_flags = 0)
    {
        if (is_null($server)) $server = ini_get("mysql.default_host");
        if (is_null($username)) $username = ini_get("mysql.default_user");
        if (is_null($password)) $password = ini_get("mysql.default_password");
        list($host, $port) = explode(":", $server);
        if (empty($port)) $port = 3306;
        return mysql_active_link(mysqli_connect($host, $username, $password, "", $port), TRUE);
    }

    function mysql_pconnect($server = NULL, $username = NULL, $password = NULL, $client_flags = 0)
    {
        return mysql_connect($server, $username, $password, FALSE, $client_flags);
    }

    function mysql_select_db($database_name, $link_identifier = NULL)
    {
        return mysqli_select_db(mysql_active_link($link_identifier), $database_name);
    }

    function mysql_get_server_info($link_identifier = NULL)
    {
        return mysqli_get_server_info(mysql_active_link($link_identifier));
    }

    function mysql_query($query, $link_identifier = NULL)
    {
        return mysqli_query(mysql_active_link($link_identifier), $query);
    }

    function mysql_real_escape_string($unescaped_string, $link_identifier = NULL)
    {
        return mysqli_real_escape_string(mysql_active_link($link_identifier), $unescaped_string);
    }

    function mysql_escape_string($unescaped_string)
    {
        return mysql_real_escape_string($unescaped_string);
    }

    function mysql_errno($link_identifier = NULL)
    {
        return mysqli_errno(mysql_active_link($link_identifier));
    }

    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    function mysql_fetch_object($result, $class_name = NULL, $params = array())
    {
        if ($class_name)
            return mysqli_fetch_object($result, $class_name, $params);
        return mysqli_fetch_object($result);
    }

    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        return mysqli_fetch_array($result, $result_type);
    }

    function mysql_fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    function mysql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }

    function mysql_free_result($result)
    {
        mysqli_free_result($result);
        return TRUE;
    }

    function mysql_db_query($database, $query, $link_identifier = NULL)
    {
        if (!mysql_select_db($link_identifier, $database)) {
            return NULL;
        }
        return mysql_query($query, $link_identifier);
    }

    function mysql_data_seek($result, $row_number)
    {
        return mysqli_data_seek($result, $row_number);
    }

    function mysql_result($result, $row, $field = 0)
    {
        mysqli_data_seek($result, $row);
        $data = mysqli_fetch_row($result);
        return @$data[$field];
    }

    function mysql_error($link_identifier = NULL)
    {
        return mysqli_error(mysql_active_link($link_identifier));
    }

    function mysql_list_dbs($link_identifier = NULL)
    {
        return mysql_query('SHOW DATABASES', $link_identifier);
    }

    function mysql_num_fields($result)
    {
        return mysqli_num_fields($result);
    }

    function mysql_set_charset($charset, $link_identifier = NULL)
    {
        return mysqli_set_charset(mysql_active_link($link_identifier), $charset);
    }

}