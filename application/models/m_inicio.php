<?php 

class m_inicio extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function tickets_pendientes_sis($usr)
    {
    	$qry = "";

    	$qry = "SELECT 
				folio
				,fecha_inicio
				,hora_inicio
				,us.usuario
				,titulo
				,categoria_ticket.categoria
				,est.situacion
				,fecha_asignado
				,hora_asignado
				,asignado.usuario usr_asignado
				,ticket.estatus
				from ticket
				LEFT JOIN  usuario us on us.codigo = ticket.usr_incidente
				LEFT JOIN categoria_ticket on categoria_ticket.id_cat = ticket.categoria
				LEFT JOIN situacion_ticket est on est.id = ticket.estatus
				LEFT JOIN usuario asignado on ticket.usr_asignado = asignado.codigo
				where usr_asignado = '$usr'
				and est.id != 5
				LIMIT 10";

		return $this->db->query($qry)->result();
    }

    function obt_conceptos()
    {
        $qry = '';

        $qry =" SELECT 
                    c.nombre,
                    count(b.concepto) as contador
                FROM
                    b_registros b
                LEFT JOIN
                    b_conceptoreporte c ON c.id = b.concepto
                GROUP BY c.nombre";

        $conceptos = $this->db->query($qry)->result();

        $array = array();
        foreach ($conceptos as $concepto) {
            $array[] = 
                $concepto->nombre;
        }
        return json_encode($array);
    }

    function obt_contador_conducta()
    {
        $qry = '';

        $qry = 'SELECT 
                    c.nombre,
                    count(b.concepto) as contador
                FROM
                    b_registros b
                LEFT JOIN
                    b_conceptoreporte c ON c.id = b.concepto
                GROUP BY c.nombre';

        $conceptos = $this->db->query($qry)->result();

        $array = array();
        foreach ($conceptos as $cuenta) {
            $array[] = 
                $cuenta->contador;
        }
        return json_encode($array);


    }

    function obt_registros()
    {
        return $this->db->get("b_registros")->num_rows();
    }

    function cont_multiples_conductas()
    {
        $qry = "";

        $qry = "SELECT
                concepto as cuenta
                from 
                b_registros
                where concepto = 0";

        return $this->db->query($qry)->num_rows();
    }
    function cont_una_conducta()
    {
        $qry = "";

        $qry = "SELECT
                concepto as cuenta
                from 
                b_registros
                where concepto != 0";


        return $this->db->query($qry)->num_rows();
    }

    function obt_conducta()
    {
        $qry = '';

        $qry = 'SELECT 
                    c.nombre,
                    count(b.concepto) as contador
                FROM
                    b_registros b
                LEFT JOIN
                    b_conceptoreporte c ON c.id = b.concepto
                GROUP BY c.nombre';

        return $this->db->query($qry)->result();
    }

      function etiqueta($estatus)
    {
        if($estatus == 1){
            $esta = '<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status"> <i class="fa fa-ticket"></i> Abierto
                        </button>';
            return $esta;
        }
        if($estatus == 2){
            $esta = '<button class="btn btn-xs bg-maroon" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status">
                            <i class="fa fa-user-plus"></i> Asigando
                      </button>';
            return $esta;
        }
          if($estatus == 3){
            $esta = '<button class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status"> <i class="fa fa-spinner"></i> En Proceso
                        </button>';
            return $esta;
        }
          if($estatus == 4){
            $esta = '<button class="btn btn-xs btn-success" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status"> 
                            <i class="fa fa-check-circle"></i> Resuelto
                        </small>';
            return $esta;
        }
            if($estatus == 5){
            $esta = '<button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status">
                <i class="fa fa-lock"></i> Cerrado
                </button>';
            return $esta;
        }
           if($estatus == 6){
            $esta = '<button class="btn btn-xs bg-black" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status"> 
                            <i class="fa  fa-hourglass-2"></i> Pendiente
                        </button>';
            return $esta;
        }
           if($estatus == 7){
            $esta = '<button class="btn btn-xs bg-orange" data-toggle="modal" data-target="#modalStatus" title="Cambiar Status">
                            <i class="fa  fa-random"></i> Reasignado
                        </button>';
            return $esta;
        }
    }
}
?>