<?php


class User
{

    /*PROPRIETES*/
    private $_id;
    private $_email;
    private $_password;
    private $_name;
    private $_last_seen;
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


    public function setEmail($email){
        $this->_email=htmlentities(strval($email));
    }

    public function getEmail(){
        return $this->_email;
    }


    public function setPassword($password){
        $this->_password=strval($password);

    }

    public function getPassword(){
        return $this->_password;
    }

    public function setName($name){
        $this->_name=strval($name);
    }

    public function getName(){
        return $this->_name;
    }


    public function setLast_seen($last_seen){
        $this->_last_seen=$last_seen;
    }

    public function getLast_seen(){
        return $this->_last_seen;
    }


    public function setAdded_at($added_at){
        $this->_added_at=htmlentities(strval($added_at));
    }

    public function getAdded_at(){
        return $this->_added_at;
    }













    /*METHODES FONCTIONNELLES*/

    public function addUser(User $user){
        include(_APP_PATH."bd/server-connect.php");
        $query=$db->prepare("INSERT INTO users VALUES (?,?,UNHEX(SHA1(?)),?,?,?)");

        $id=0;
        $email=$user->getEmail();
        $password=$user->getPassword();
        $name=$user->getName();
        $last_seen=$user->getLast_seen();
        $added_at=$user->getAdded_at();

        $query->bindParam(1,$id);
        $query->bindParam(2,$email);
        $query->bindParam(3,$password);
        $query->bindParam(4,$name);
        $query->bindParam(5,$last_seen);
        $query->bindParam(6,$added_at);


        if($query->execute()){
          return true;
      }else{
          return false;
      }
  }







  public function removeUser($id_user){
    include(_APP_PATH."bd/server-connect.php");

    $id_user=intval($id_user);

    $req=$db->prepare("DELETE FROM users WHERE id=?");

    $req->bindParam(1,$id_user);

    if($req->execute()){
        return true;
    }else{
        return false;
    }

}


public function getLastUser(){
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users)");
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new User($data));
    }else{
        return false;
    }
}




public function getUser($id){
    include(_APP_PATH."bd/server-connect.php");


    $id=intval($id);
    $query=$db->prepare("SELECT * FROM users WHERE id=?");
    $query->bindParam(1,$id);
    if($query->execute() && $query->rowCount()==1){
        $data=$query->fetch();
        return (new User($data));
    }else{
        return false;
    }

}




public function getUsers() {
    include(_APP_PATH."bd/server-connect.php");
    $session = new Session();
    $role= strval($session->getRole_3());
    $query=$db->prepare("SELECT * FROM users WHERE role != ? ORDER BY name ASC");
    $query->bindParam(1,$role);

    $users=[];

    if($query->execute()){
        while($data=$query->fetch()){
            $users[]=new User($data);
        }
        return $users;
    }else{
        return false;
    }
}







public function editUser(User $user) {
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("UPDATE users
        SET email=?,
        role=?,
        name=?,
        last_seen=?
        WHERE id=?

        ");

    $id=$user->getId();
    $email=$user->getEmail();
    $name=$user->getName();
    $last_seen=$user->getLast_seen();

    $query->bindParam(1,$email);
    $query->bindParam(2,$name);
    $query->bindParam(3,$last_seen);
    $query->bindParam(4,$id);

    if($query->execute()){

        return true;

    }else{
        return false;
    }
}



public function updateLastSeen($id) {
    include(_APP_PATH."bd/server-connect.php");

    $last_seen=date("Y-m-d H:i:s");

    $query=$db->prepare("UPDATE users SET last_seen=? WHERE id=?");

    $query->bindParam(1,$last_seen);
    $query->bindParam(2,$id);

    if($query->execute()){

        return true;

    }else{
        return false;
    }
}





public function editPassword(User $user) {
    include(_APP_PATH."bd/server-connect.php");

    $query=$db->prepare("UPDATE users
        SET password=UNHEX(SHA1(?))
        WHERE id=?

        ");

    $id=$user->getId();
    $password=$user->getPassword();

    $query->bindParam(1,$password);
    $query->bindParam(2,$id);

    if($query->execute()){

        return true;

    }else{
        return false;
    }
}





public function logIn(User $user) {
    include(_APP_PATH."bd/server-connect.php");

    $blocked=0;

    /* Recherche de l'utilisateur */
    $query=$db->prepare("SELECT * FROM users WHERE email=? AND password=UNHEX(SHA1(?))");

    $email=$user->getEmail();
    $password=$user->getPassword();

    $query->bindParam(1,$email);
    $query->bindParam(2,$password);

    if($query->execute()){
        /* Si son compte a été trouvé */
        if($query->rowCount()==1){

            $data=$query->fetch();

            $user_found=new user($data);
            $_SESSION['type']="user";
            $_SESSION['id']=$user_found->getId();
            $_SESSION['email']=$user_found->getEmail();
            $_SESSION['name']=$user_found->getName();
            $_SESSION['added_at']=$user_found->getAdded_at();

            return true;

        }else{
            /* Si son compte n'a pas été trouvé */
            return "not found";
        }
    }else{
        return false;
    }
}






public function logOut() {
    $_SESSION=array();
}



}

?>
