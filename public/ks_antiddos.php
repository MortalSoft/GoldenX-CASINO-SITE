<?

//-----------------------------
// KlavaSoft AntiDDOS ver. 2.1
// (C) Cosinus, Klavasoft.com
// http://klavasoft.com/antiddos
//-----------------------------




class ks_antiddos
{
	var $seconds_limit, $hits_limit, $memlen;
	var $status, $error_msg, $now;
	var $visitor; // статус визитора
	var $warm_level; // количиство хитов за seconds_limit секундпри котором статус визитора устанавливаетс¤ в warm
	var $iplist_var = 1; // номер переменной списка в шареде
	var $auto = true; 
	var $delay = 20; // задержка предлагаема¤ блокируемым визиторам
	
	
	function doit($seconds_limit,$hits_limit,$memlen=100000)
	{
		if (!function_exists('shm_attach')) return $this->alles(false);
		$this->seconds_limit = $seconds_limit;
		$this->hits_limit = $hits_limit;
		$this->memlen = $memlen;
		$this->visitor = 'raw'; // необработан
		if (empty($this->warm_level)) 
			$this->warm_level = $this->hits_limit/2;
		$this->now = time();
	// читаем список
		if (false===$this->read_iplist()) return $this->alles(false);
	// прочистка списка
		$this->clean_list();
	// добавл¤ем этот заход
		$ip = $_SERVER['REMOTE_ADDR'];
		if (@!is_array($this->iplist[$ip])) $this->iplist[$ip] = array();
		$this->iplist[$ip][] = $this->now;
	// сохран¤ем список
		if (false===$this->save_iplist()) return $this->alles(false);
		$count = count($this->iplist[$ip]);
		$this->status = 'ok';
		if ($count==1) // если есть только этот заход в массиве
			$this->visitor = "new";
		elseif ($count>$this->hits_limit)
			$this->visitor = "hot";
		elseif ($count>=$this->warm_level) 
			$this->visitor = "warm";
		else
			$this->visitor = "cool";
		return $this->alles(true);
	}

// прочистка списка	
	function clean_list()
	{
		foreach($this->iplist as $ip=>$times)
		{
			$times_count = count($times);
		// исщем заход, который надо оставить вместе с последующими
			$actual_ptr = -1;
			for($i=0; $i<$times_count; $i++)
			{
				if ($times[$i]+$this->seconds_limit>$this->now)
				{ // нашли
					$actual_ptr = $i;
					break;
				}
			}
			if ($actual_ptr==-1) // очищаем »ѕ
			{
				unset($this->iplist[$ip]);
				continue;
			}
			else
			{
				$actual_ptr = max($actual_ptr,$times_count-$this->hits_limit);
				$this->iplist[$ip] = array_slice($times,$actual_ptr);
			}
			
		}
	}
	
	
	function read_iplist()
	{
	// подключаемс¤ к пам¤ти
		$shm_token = ftok(__FILE__,' ');
		$this->shm_id = shm_attach($shm_token,$this->memlen,0766);
		if (false===$this->shm_id) 
		{
			$this->status = 'error';
			$this->error_msg = 'cannot attach shared memory. ';
			return false;
		}
		$this->iplist = @shm_get_var($this->shm_id,$this->iplist_var);
		if (false===$this->iplist)
		{ // создаем переменную в шареде
			$this->iplist = array();
			$res = @shm_put_var($this->shm_id,$this->iplist_var,$this->iplist);
			if (false===$res) 
			{
				$this->status = 'error';
				$this->error_msg = 'cannot create shared iplist. ';
				return false;
			}
		}
		return true;
	}
	
	function save_iplist()
	{
		$res = true;
		if (false===shm_put_var($this->shm_id,$this->iplist_var,$this->iplist)) $res = false;
		return $res;
	}
	
	function getmicrotime() 
	{ 
		list($usec, $sec) = explode(" ", microtime()); 
		return ((float)$usec + (float)$sec); 
	} 	
	
	function alles($res=true)
	{
		if (!empty($this->shm_id)) 
		{
			if (false===@shm_detach($this->shm_id)) 
				$this->error_msg .= '; error detaching shared memory. ';
		}
		if (!empty($this->error_msg) )
		{
			$this->status = 'error';
			$res = false;
		}
		if ($this->auto && $this->visitor=='hot')
		{
			header('HTTP/1.0 503 Service Unavailable');
			header('Status: 503 Service Unavailable');
			header('Retry-After: 30');
			print "<html><meta http-equiv='refresh' content='$this->delay'><body><h2>Our server is currently overloaded, your request will be repeated automatically in $this->delay seconds</h2>";
			die();
		}
		return $res;
	}
}

if (strrchr($_SERVER['SCRIPT_NAME'],'/')==='/ks_antiddos.php')
{ // вызов напр¤мую из браузера
error_reporting(E_ALL);
	print "<h3>ks_antiddos control pannel</h3>";
	$delete_shm = @$_GET['delete'];
	$shm_token = ftok(__FILE__,' ');
	if ($delete_shm)
	{
		print "Deleting shared memory... ";
		$shm_id = shm_attach($shm_token);
		$res = shm_remove($shm_id);
		if ($res)  
			print "Successfull";
		else 
			print "Failed";
	}
	$shm_token_hex = dechex($shm_token);
	print "<br>my shared memory blocks";
	$shms = `ipcs -m`;
	$shms = explode("\n",$shms);
	$header = preg_grep('~key~i',$shms);
	$header = array_values($header);
	$header = $header[0];
	$myshms = preg_grep("~$shm_token_hex~",$shms);
	$anyway = '';
	if (empty($myshms))
	{
		print "<li>not found";
		$anyway = 'anyway';
	}
	$header = preg_split('/[\s\t]+/',$header);
	$header = ' '.implode(' ',$header);
	$header = str_replace(' ','<th>',$header);
	print "<table border=1><thead>$header</thead>\n";
	$myshms = array_values($myshms);
	foreach($myshms as $num=>$line)
	{
	
		$line = preg_split('/[\s\t]+/',$line);
		$shm_id = $line[1];
		$line = ' '.implode(' ',$line);
		$line = str_replace(' ','<td>',$line);
		print "<tr>$line
			</tr>\n";
	}
	print "</table>
		<a href=?delete=1>delete it $anyway</a>";
	$ksa = new ks_antiddos();
	$res = $ksa->read_iplist();
	if (!$res) print "<br>Cannot read IP list: ".$ksa->error_msg;
	if ($res)
	{
		$count_ips = count($ksa->iplist);
		print "\n<p>&nbsp;</p><li>total $count_ips stored IPs";
		print "\n<table cellspacing=3>";
		foreach($ksa->iplist as $ip=>$times)
		{
			print "\n<tr><td>$ip<td>".count($times)." hits</tr>";
		}
		print "\n</table>";
		print "Please note, that these data was actual when the last hit occured and I store no more then  <b>hits_limit</b> hits";
		$ksa->alles();
	}
	else $ksa->alles();
}


?>