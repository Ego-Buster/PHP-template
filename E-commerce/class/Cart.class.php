<?php


class Cart
{

    /*PROPRIETES*/
    private $_id;
    private $_id_article;
    private $_id_user;
    private $_quantity;
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


    public function setId_article($id_article){
        $this->_id_article=intval($id_article);
    }

    public function getId_article(){
        return $this->_id_article;
    }


    public function setId_user($id_user){
        $this->_id_user=intval($id_user);
    }

    public function getId_user(){
        return $this->_id_user;
    }


    public function setQuantity($quantity){
        $this->_quantity=intval($quantity);
    }

    public function getQuantity(){
        return $this->_quantity;
    }


    public function setAdded_at($added_at){
        $this->_added_at=htmlentities(strval($added_at));
    }

    public function getAdded_at(){
        return $this->_added_at;
    }













    /*METHODES FONCTIONNELLES*/

    public function addCart(Cart $cart){
        include(_APP_PATH."bd/server-connect.php");

        $query=$db->prepare("INSERT INTO carts VALUES (?,?,?,?,?)");

        $id=0;
        $id_article=$cart->getId_article();
        $id_user=$cart->getId_user();
        $quantity=$cart->getQuantity();
        $added_at=$cart->getAdded_at();

        $query->bindParam(1,$id);
        $query->bindParam(2,$id_article);
        $query->bindParam(3,$id_user);
        $query->bindParam(4,$quantity);
        $query->bindParam(5,$added_at);


        if($query->execute()){
          return true;
      }else{
          return false;
      }
  }






  public function removeCart($id_cart){
    include(_APP_PATH."bd/server-connect.php");

    $id_cart=intval($id_cart);
    $req=$db->prepare("DELETE FROM carts WHERE id=?");

    $req->bindParam(1,$id_cart);

    if($req->execute()){
        return true;
    }else{
        return false;
    }

}


public function getLastCart(){
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("SELECT * FROM carts WHERE id=(SELECT MAX(id) FROM carts)");
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Cart($data));
    }else{
        return false;
    }
}



public function getCart($id){
    include(_APP_PATH."bd/server-connect.php");

    $id=intval($id);
    $query=$db->prepare("SELECT * FROM carts WHERE id=?");
    $query->bindParam(1,$id);
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new Cart($data));
    }else{
        return false;
    }

}




public function getCarts() {
    include(_APP_PATH."bd/server-connect.php");


    $query=$db->prepare("SELECT * FROM carts ORDER BY id DESC");

    $cart=[];

    if($query->execute()){
        while($data=$query->fetch()){
            $cart[]=new Cart($data);
        }
        return $cart;
    }else{
        return false;
    }
}







public function editCart(Cart $cart) {
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("UPDATE carts
        SET id_article=?,
        id_user=?,
        quantity=?
        WHERE id=?

        ");

    $id=$cart->getId();
    $id_article=$cart->getId_article();
    $id_user=$cart->getId_user();
    $quantity=$cart->getQuantity();

    $query->bindParam(1,$id_article);
    $query->bindParam(2,$id_user);
    $query->bindParam(3,$quantity);
    $query->bindParam(4,$id);

    if($query->execute()){

        return true;

    }else{
        
        return false;
    }
}




}

?>
