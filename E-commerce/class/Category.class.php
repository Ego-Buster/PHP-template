<?php


class Category
{

    /*PROPRIETES*/
    private $_id;
    private $_id_admin;
    private $_name;
    private $_added_at;

    /*CONSTRUCTEUR*/
    public function __construct(array $data){

        foreach ($data as $key => $value) {
            $method='set'.ucfirst($key);

            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }


    /*SETTERS & GETTERS*/

    public function setId($id){
        $this->_id=intval($id);
    }

    public function getId(){
        return $this->_id;
    }


    public function setId_admin($id_admin){
        $this->_id_admin=intval($id_admin);
    }

    public function getId_admin(){
        return $this->_id_admin;
    }


    public function setName($name){
        $this->_name=htmlentities(strval($name));
    }

    public function getName(){
        return $this->_name;
    }


    public function setAdded_at($added_at){
        $this->_added_at=htmlentities(strval($added_at));
    }

    public function getAdded_at(){
        return $this->_added_at;
    }













    /*METHODES FONCTIONNELLES*/

    public function addCategory(Category $category){
        include(_APP_PATH."bd/server-connect.php");

        $query=$db->prepare("INSERT INTO category VALUES (?,?,?,?)");

        $id=0;
        $id_admin=$category->getId_admin();
        $name=$category->getName();
        $added_at=$category->getAdded_at();

        $query->bindParam(1,$id);
        $query->bindParam(2,$id_admin);
        $query->bindParam(3,$name);
        $query->bindParam(4,$added_at);


        if($query->execute()){
          return true;
      }else{
          return false;
      }
  }






  public function removeCategory($id_category){
    include(_APP_PATH."bd/server-connect.php");

    $id_category=intval($id_category);
    $req=$db->prepare("DELETE FROM category WHERE id=?");

    $req->bindParam(1,$id_category);

    if($req->execute()){
        return true;
    }else{
        return false;
    }

}


public function getLastCategory(){
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("SELECT * FROM category WHERE id=(SELECT MAX(id) FROM category)");
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Category($data));
    }else{
        return false;
    }
}



public function getCategory($id){
    include(_APP_PATH."bd/server-connect.php");

    $id=intval($id);
    $query=$db->prepare("SELECT * FROM category WHERE id=?");
    $query->bindParam(1,$id);
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Category($data));
    }else{
        return false;
    }

}




public function getCategory() {
    include(_APP_PATH."bd/server-connect.php");


    $query=$db->prepare("SELECT * FROM category ORDER BY id DESC");

    $category=[];

    if($query->execute()){
        while($data=$query->fetch()){
            $category[]=new Category($data);
        }
        return $category;
    }else{
        return false;
    }
}







public function editCategory(category $category) {
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("UPDATE category
        SET id_admin=?,
        name=?
        WHERE id=?
        ");

    $id=$category->getId();
    $id_admin=$category->getId_admin();
    $name=$category->getName();

    $query->bindParam(1,$id_admin);
    $query->bindParam(2,$name);
    $query->bindParam(3,$id);

    if($query->execute()){

        return true;

    }else{
        return false;
    }
}




}

?>
