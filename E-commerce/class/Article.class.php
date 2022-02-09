<?php


class Article
{

    /*PROPRIETES*/
    private $_id;
    private $_id_category;
    private $_name;
    private $_price;
    private $_file;
    private $_description;
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


    public function setId_category($id_category){
        $this->_id_category=intval($id_category);
    }

    public function getId_category(){
        return $this->_id_category;
    }


    public function setName($name){
        $this->_name=htmlentities(strval($name));
    }

    public function getName(){
        return $this->_name;
    }


    public function setPrice($price){
        $this->_price=intval($price);
    }

    public function getPrice(){
        return $this->_price;
    }


    public function setFile($file){
        $this->_file=htmlentities(strval($file));
    }

    public function getFile(){
        return $this->_file;
    }


    public function setDescription($description){
        $this->_description=htmlentities(strval($description));
    }

    public function getDescription(){
        return $this->_description;
    }



    public function setAdded_at($added_at){
        $this->_added_at=htmlentities(strval($added_at));
    }

    public function getAdded_at(){
        return $this->_added_at;
    }













    /*METHODES FONCTIONNELLES*/

    public function addArticle(Article $article){
        include(_APP_PATH."bd/server-connect.php");

        $query=$db->prepare("INSERT INTO articles VALUES (?,?,?,?,?,?,?)");

        $id=0;
        $id_category=$article->getId_category();
        $name=$article->getName();
        $price=$article->getPrice();
        $file=$article->getFile();
        $description=$article->getDescription();
        $added_at=$article->getAdded_at();

        $query->bindParam(1,$id);
        $query->bindParam(2,$id_category);
        $query->bindParam(3,$name);
        $query->bindParam(4,$price);
        $query->bindParam(5,$file);
        $query->bindParam(6,$description);
        $query->bindParam(7,$added_at);


        if($query->execute()){
          return true;
      }else{
          return false;
      }
  }






  public function removeArticle($id_article){
    include(_APP_PATH."bd/server-connect.php");

    $id_article=intval($id_article);
    $req=$db->prepare("DELETE FROM articles WHERE id=?");

    $req->bindParam(1,$id_article);

    if($req->execute()){
        return true;
    }else{
        return false;
    }

}


public function getLastArticle(){
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("SELECT * FROM articles WHERE id=(SELECT MAX(id) FROM articles)");
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Article($data));
    }else{
        return false;
    }
}



public function getArticle($id){
    include(_APP_PATH."bd/server-connect.php");

    $id=intval($id);
    $query=$db->prepare("SELECT * FROM articles WHERE id=?");
    $query->bindParam(1,$id);
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Article($data));
    }else{
        return false;
    }

}




public function getArticles() {
    include(_APP_PATH."bd/server-connect.php");


    $query=$db->prepare("SELECT * FROM articles ORDER BY id DESC");

    $article=[];

    if($query->execute()){
        while($data=$query->fetch()){
            $article[]=new Article($data);
        }
        return $article;
    }else{
        return false;
    }
}







public function editArticle(Article $article) {
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("UPDATE articles
        SET id_category=?,
        name=?,
        price=?,
        file=?,
        description=?
        WHERE id=?

        ");

    $id=$article->getId();
    $id_category=$article->getId_category();
    $name=$article->getName();
    $price=$article->getPrice();
    $file=$article->getFile();
    $description=$article->getDescription();

    $query->bindParam(1,$id_category);
    $query->bindParam(2,$name);
    $query->bindParam(3,$price);
    $query->bindParam(4,$file);
    $query->bindParam(5,$description);
    $query->bindParam(6,$id);

    if($query->execute()){

        return true;

    }else{
        return false;
    }
}




}

?>
