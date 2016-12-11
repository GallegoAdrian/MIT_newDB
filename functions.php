<?php

// BASE DE DATOS: start
// ********************
//Se connecta a la base de datos
function connectDB(){
	$servidor = "localhost";
	$usuario  = "g3s2aw";
	$password = "1234";
	$DB       = "g3s2aw_mit";
	$connect  = mysqli_connect($servidor,$usuario,$password,$DB);
	mysqli_set_charset($connect, "utf8");

	return $connect;
}

/*
Selecciona la información que le pidas de la base de datos.
PARAMETROS:
	connect (variable que retorna connectDB), 
	arg (los argumentos que quieres que retorne),
	table (las tablas de donde quieres que saque la info),
	where (en caso que quieras poner un where añadelo, sino dejalo en blanco o en NULL)
 */
function select($connect, $arg, $table, $where = null){
	$sql = "SELECT {$arg} FROM {$table}";
	if ($where === null) {
		$sql .= ';';
	}
	else{
		$sql .= " WHERE {$where};";
	}
	$result = mysqli_query($connect, $sql);
	return $result;
}
//BASE DE DATOS: end

// SELECT: start
// *************
//devuelve todas las asignaturas que el usuario esta impartiendo PARAMETROS: username (nombre del usuario) y connect (variable que retorna connectDB)
function getAsignaturasI($username, $connect){
	$result = select($connect,
			'asi.descripcion as asignatura, asi.codigo as codigo',
			'usuario us, persona pe, profesor pr, imparte im, asignatura asi',
			'us.id_usuario = pe.id_persona
			AND pe.id_persona = pr.id_profesor
			AND pr.id_profesor = im.id_profesor
			AND im.id_asignatura = asi.id_asignatura
			AND us.username = "'.$username.'"');
	return $result;
}
//devuelve todas las asignaturas que el usuario esta preparando PARAMETROS: nombre (nombre del usuario) y connect (variable que retorna connectDB)
function getAsignaturasP($username, $connect){
	$result = select($connect,
			'asi.descripcion as asignatura, asi.codigo as codigo',
			'usuario us, persona pe, profesor pr, prepara pre, asignatura asi',
			'us.id_usuario = pe.id_persona
			AND pe.id_persona = pr.id_profesor
			AND pr.id_profesor = pre.id_profesor
			AND pre.id_asignatura = asi.id_asignatura
			AND us.username = "'.$username.'"');
	return $result;
}
//devuelve toda la información de la asignatura PARAMETROS: nombre (codigo de la asignatura) y connect (variable que retorna connectDB)
function getAsignatura($code, $connect){
	$result = select($connect, '*', 'asignatura', 'codigo = "'.$code.'"');
	$row = mysqli_fetch_array($result);

	return $row;
}
//devuelve del id del alumno PARAMETROS: username (username del alumno) y connect (variable que retorna connectDB)
function getAlumnoId($username, $connect){
	$result = select($connect,
			'al.id_alumno as id', 'alumno al, persona pe, usuario us',
			'al.id_alumno = pe.id_persona AND us.id_usuario = pe.id_persona and us.username = "'.$username.'" LIMIT 1');
	$row = mysqli_fetch_array($result);

	return intval($row['id']);
}

//devuelve el "Nombre completo" de la persona (apellidos, nombre) -- PARAMETROS: username (username del usuario) y connect (variable que retorna connectDB)
function getDatosPersona($username, $connect){
	$result = select($connect, 'concat(pe.apellidos,", ",pe.nombre) as nombre', 'persona pe, usuario us', 'us.id_usuario = pe.id_persona and us.username = "'.$username.'" LIMIT 1');
	$row = mysqli_fetch_array($result);
	//return $row;
	return $row['nombre'];
}

function getMenuSecretaria($connect){
	$result = select($connect, '*', 'menusecretaria');
	$row = mysqli_fetch_array($result);
	return $row;
}

//SELECT: end

//Desloguea al usuario
function logout(){
	session_start();
	session_destroy();
	header("location:index.php");
}
//Retorna el header
function getHeader($ruta = null){
	if ($ruta == null) {
		echo '<header>
            <div id="title">
              <span>Massachusetts Institute of Technology</span>
              <img class="logo" src="'.$ruta.'images/mit.png">
          	</div>
      </header>';
	}
	else{
		echo '<header>
			<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">Menu</span><span class="cd-menu-icon"></span></a>
            <div id="title">
              <span>Massachusetts Institute of Technology</span>
              <img class="logo" src="'.$ruta.'images/mit.png">
          	</div>
    	</header>';
	}
}
//Retorna el footer
function footer($ruta = null){
	if ($ruta == null) {
		echo "<footer><div style='float: left; text-align: left;'><p id='alumne'>Alumne: llorens.anna / 46258585M</p><p id='profesor'>Professor: gomez.eva / 21111222A</p><p id='coordinador'>Coordinador: cifuentes.agapito / 55777666A</p><p id='secretaria'>Secretaria: god / god</p></div><span> © MIT, 2016-2017</span></footer>";
	}else{
		echo "<footer><span> © MIT, 2016-2017</span></footer>";
	}
}
/*
type:
	1 => alumno
	2 => profesor
	3 => coordinador
	4 => secretaria
	...
*/
//Retorna el menú según el usuario
	function getMenu($type, $connect){
	// obtiene nombre completo persona
	$nombrePer = getDatosPersona($_SESSION['username'], $connect);
	
	//obtiene nombre y url de la tabla menu
	$consulta = "SELECT nombre, url FROM menu WHERE tipo_usuario = '$type'";
	$result = mysqli_query($connect, $consulta);

			echo '<nav id="cd-lateral-nav">
			<ul class="cd-navigation">
			<div class="profile">
				<img class="user" alt="foto-perfil" src="https://www.buira.org/assets/images/shared/default-profile.png">
				<p class="user-name">Bienvenido/a:</br></br>'.$nombrePer.'</p>
			</div>
			<ul class="cd-navigation cd-single-item-wrapper">';
				foreach ($result as $line) {
					$url = $line['url'];
					if(strpos($_SERVER['REQUEST_URI'], $url) !== false){
						echo '<li><a class="active" href="'.$line['url'].'" >'.$line['nombre'].'</a></li>';
					}
					elseif(substr($_SERVER['REQUEST_URI'], -1) == '/' && $line['url'] == 'index.php'){
						echo '<li><a class="active" href="'.$line['url'].'" >'.$line['nombre'].'</a></li>';
					}
					else{
						echo '<li><a href="'.$line['url'].'" >'.$line['nombre'].'</a></li>';
					}
				}
				echo '</ul>';
				if($type == 2){
					$result = getAsignaturasP($_SESSION["username"], $connect);
					echo '<li class="item-has-children">
					<a href="#0">Preparando</a>
					<ul class="sub-menu">';
					foreach ($result as $asignaturas) {
						$url = $_SERVER['REQUEST_URI'];
						$pos = strrpos($url, $asignaturas['codigo']);
						$preparadas = strrpos($url, 'preparadas');

						if($pos !== false && $preparadas !== false){
						    echo '<li><a class="active" href="preparadas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></li>';
						}else{
							echo '<li><a href="preparadas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></li>';
						}
					}
					echo '</ul></li>
					<li class="item-has-children">
					<a href="#0">Impartiendo</a>
					<ul class="sub-menu">';

					$result = getAsignaturasI($_SESSION["username"], $connect);
					foreach ($result as $asignaturas) {
						$url = $_SERVER['REQUEST_URI'];
						$pos = strrpos($url, $asignaturas['codigo']);

						if($pos !== false  && $preparadas === false){
						    echo '<li><a class="active" href="impartidas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></li>';
						}else{
							echo '<li><a href="impartidas.php?a='.$asignaturas['codigo'].'">'.$asignaturas['asignatura'].'</a></li>';
						}
					}
					echo '</ul></li>';
				}else if($type == 4){
					//echo $_SERVER['REQUEST_URI'];
					$consulta = "SELECT nombre, url FROM menusecretaria";
					$result = mysqli_query($connect, $consulta);

					foreach ($result as $line) {
						$url = $_SERVER['REQUEST_URI'];
						$pos = strrpos($url, $line['url']);
						if($pos !== false){
							    echo '<li><a class="active" href="'.$line['url'].'">'.$line['nombre'].'</a></li>';
							}else{
								echo '<li><a href="'.$line['url'].'">'.$line['nombre'].'</a></li>';
							}
					}

				}
				echo '<ul class="cd-navigation cd-single-item-wrapper">
				<li><a href="#0">Configuración</a></li>
				<li><a href="../index.php?action=logout">Logout</a></li>
				</ul> <!-- cd-single-item-wrapper -->
				</nav>';
	}


	/*
	PDF: START
	*/
	require_once('pdf/tfpdf.php');
		class PDF extends tFPDF
		{
			// Cabecera de página
			function Header()
			{
			    // Logo
			    $this->Image('images/mit.png',10,8,33);
			    // Arial bold 15
			    $this->SetFont('Arial','B',15);
			    // Movernos a la derecha
			    $this->Cell(80);
			    // Título
			    $this->Cell(30,10,'Notas ',0,0,'C');
			    // Salto de línea
			    $this->Ln(20);
			}

			// Pie de página
			function Footer()
			{
			    // Posición: a 1,5 cm del final
			    $this->SetY(-15);
			    // Arial italic 8
			    $this->SetFont('Arial','I',8);
			    // Número de página
			    $this->Cell(0,10,'Page '.$this->PageNo().'/1',0,0,'C');
			}
			function ChapterTitle($num, $today)
			{
			    // Arial 12
			    $this->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			    $this->SetFont('DejaVu','',14);
			    // Color de fondo
			    $this->SetFillColor(200,220,255);
			    // Título
			    $this->Cell(0,6,"$num",0,0,'L',true);
			    $this->Cell(0,6," Creado: $today[mday] - $today[mon] - $today[year]",0,1,'R', false);
			}
		}

	function pdf($id, $method){
		$conn = connectDB();
		$result = getNotasAlumno($conn, $id);
		$pdf = new PDF();
		$pdf->AddPage();
		// Add a Unicode font (uses UTF-8)
		$today = getdate();
		$return = getNombreId($conn, $id);
		$pdf->ChapterTitle($return['nombre'].' '.$return['apellidos'], $today);
		$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$pdf->SetFont('DejaVu','',14);
		
		foreach ($result as $asignatura) {
			$pdf->Cell(150,10,$asignatura['descripcion'],0,0);
			$pdf->Cell(40,10,$asignatura['nota'],0,1,'R');
		}
		if ($method == 'download') {
			# code...
			$pdf->Output('notas.pdf', 'D');
		}
		elseif ($method == 'view') {
			$pdf->Output();	
		}
		else{
			$pdfdoc = $pdf->Output('', 'S');
			return $pdfdoc;
		}
	}

	/*
	PDF: END
	*/

	function getNotasAlumno($conn, $id){
		$result = select($conn,
			'descripcion, nota, baixa',
			'asignatura a INNER JOIN matricula m ON a.id_asignatura = m.id_asignatura', 
			'm.id_alumno = '.$id
		);
		return $result;

	}
	function getNombreId($conn, $id){
		$result = select($conn,
			'nombre, apellidos',
			'alumno a INNER JOIN persona p ON a.id_alumno = p.id_persona', 
			'a.id_alumno = '.$id.' LIMIT 1'
		);
		$row = mysqli_fetch_array($result);
		return $row;
	}
	function getMail($conn, $dni){
		$result = select($conn, 'id_persona as id, email, nombre, apellidos', 'persona', 'dni = "'.$dni.'" LIMIT 1');
		$row = mysqli_fetch_array($result);

		return $row;
	}
?>