<?php

$connect = new PDO("mysql:host=localhost;dbname=research", "root", "");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();


// $conn = mysqli_connect('localhost', 'root', '', 'research');
// if($con->connect_error){
//   die("Connection Failed">$con->connect_error);
// }
// $result = array('error'=>false);
// $received_data = json_decode(file_get_contents("php://input"));
// $data = array();


if($received_data->action == 'fetchallQuestion'){

  $query = "SELECT q.id_question, q.id_dimension, q.question as question, d.name as dimension
            FROM TB_QUESTIONS as q
            INNER JOIN TB_DIMENSIONS as d ON q.id_dimension = d.id_dimension and d.delete_date is null
            WHERE q.delete_date is null
          ";
  $statement = $connect->prepare($query);
  $statement->execute();
  while($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    $data[] = $row;
  }
  
  echo json_encode($data);
}

if($received_data->action == 'fetchallDimensions'){

  $query = "SELECT * FROM TB_DIMENSIONS
            WHERE delete_date is null
          ";
  $statement = $connect->prepare($query);
  $statement->execute();
  while($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    $data[] = $row;
  }
  
  echo json_encode($data);
}

if($received_data->action == 'insert')
{
 $data = array(
  ':id_dimension' => $received_data->id_dimension,
  ':question' => $received_data->question
 );

 $query = "INSERT INTO TB_QUESTIONS (question, status, id_dimension) 
VALUES (:question,'A', :id_dimension )
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Criado com sucesso'
 );

 echo json_encode($output);
}

if($received_data->action == 'fetchSingle'){
  $query = "SELECT q.id_question, q.id_dimension, q.question as question
            FROM TB_QUESTIONS as q
            WHERE q.delete_date is null and q.id_question = '".$received_data->id_question."'
  ";

  $statement = $connect->prepare($query);

  $statement->execute();

  $result = $statement->fetchAll();

  foreach($result as $row)
  {
    $data['id_question'] = $row['id_question'];
    $data['id_dimension'] = $row['id_dimension'];
    $data['question'] = $row['question'];
  }

  echo json_encode($data);
}

if($received_data->action == 'update'){
  $data = array(
    ':question' => $received_data->question,
    ':id_dimension' => $received_data->id_dimension,
    ':id_question'   => $received_data->hiddenIdQuestion
  );

  $query = "UPDATE TB_QUESTIONS  
  SET question = :question, 
  id_dimension = :id_dimension
  WHERE id_question = :id_question
  
  ";

  $statement = $connect->prepare($query);

  $statement->execute($data);

  $output = array(
    'message' => 'Editado com sucesso'
  );

  echo json_encode($output);
}

if($received_data->action == 'delete'){
  $query = "UPDATE TB_QUESTIONS  
            SET delete_date  = current_timestamp 
            WHERE  id_question = ".$received_data->id_question."
  ";

  $statement = $connect->prepare($query);

  $statement->execute();

  $output = array(
    'message' => 'Pergunta excluída'
  );

  echo json_encode($output);
}

?>