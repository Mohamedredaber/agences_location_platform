<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$_POST/ $_GET == katkhdm bihom 3la 7asaab lmethod lidrti f balise form ida drti get okhdmùti bl post raytala3lk error 
walakin kayna waa7d l9adya lihya $_REQUEST hadii la ida khdmti biha hya maxi so9a wax nta khdmti bl post get ...

$nom = $_POST["nom"]
$pre = $_POST["prenom"]
//---------

 
- redirection hya kidir mn page dyal login l page dyal accueil ==> okadirha b  header("location:form-merci.html") 

- labriti tkhddm bxi fichier (matalan : json , image , video , txt ) katziid wa7dd l3iba smitha enctype="multipart/form-data" whadi kat7ta fl form  
whaad lfichier utilisateu rhopwa liradi idakhalaha 

- variable superglobale $_SERVER['request_method']==> hadii katjiblk lmethod liknti drti flmethod wax get wla post 
$x = $_SERVER['PHP_SELF'];hadi katjiblk cemùauin li flaction 
$xxx= $_SERVER['REMOTE_ADDR'];hadi kat3tik adresse
obaa9i .... 

$_ENV ==> hadi katsta3ml flaravelle  okatkhazzn fiha dok 
$_cookies / $_session ==> 

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
PHP_EOL ==> b7aal \n ;


//////////////////////////////////////////////////////////////////////////////////////////////
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$_POST/ $_GET == katkhdm bihom 3la 7asaab lmethod lidrti f balise form ida drti get okhdmùti bl post raytala3lk error 
walakin kayna waa7d l9adya lihya $_REQUEST hadii la ida khdmti biha hya maxi so9a wax nta khdmti bl post get ...

$nom = $_POST["nom"]
$pre = $_POST["prenom"]
//---------

 
- redirection hya kidir mn page dyal login l page dyal accueil ==> okadirha b  header("location:form-merci.html") 

- labriti tkhddm bxi fichier (matalan : json , image , video , txt ) katziid wa7dd l3iba smitha enctype="multipart/form-data" whadi kat7ta fl form  
whaad lfichier utilisateu rhopwa liradi idakhalaha 

- variable superglobale $_SERVER['request_method']==> hadii katjiblk lmethod liknti drti flmethod wax get wla post 
$x = $_SERVER['PHP_SELF'];hadi katjiblk cemùauin li flaction 
$xy= $_SERVER['REMOTE_ADDR'];hadi kat3tik adresse
obaa9i .... 

$_ENV ==> hadi katsta3ml flaravelle  okatkhazzn fiha dok 
$_cookies / $_session ==> 
//////////////////////////////////////////////////////////////////////////////////////////////
---------------------------------------------fichier-------------------------------------------------
$fichier = fopen('fichier.txt','r'); r+ ==> t9ra + tktb 
a ==> tktb bla matmssa7 w ida makanx ktcree , a+ == > kat9ra wtktb w ida makanx ktcree 
w ==> ratcree ida makanx ficjier  ida kan kayyn ratmsaa7 lcontenue 

bax t9raa fichier :
-- $allcontent = fread($fichier , filesize('fichier.txt')) had fielsize ==  9ra fichier kolo ,,,, ida drtii ra9mm hnaa kiyakhood octé ya3ni 5 co dyal les donnes
    or file('fichier')
-- $staaarlewle = fgets($fichier); /// fgetc hadi katjiblk car b cara 
-- fclose($fichier);
-- feof($) ????
-- frwrite($fichier , $text) hadi rh katajouter m3a akhiir caractere ya3ni maxii katnaa9azz star o3ad katktb  -- 
-- fseek($fichier , kadir hna mnin briti tbda ktaba okadir ra9mm )
-$_FILES
bax tenregetre 
$_FILES['nom de la varible']['name katb9a haka ']

//////////////////////////////////////////////////////////////////////////////////////////////
----------------------------------------------POO--------------------------------------------------------
class Fruit{
    // les method (propriete)
    private $oooo; 

    public function ***($name){
        $this -> username =  $name ; // this(z3ma fin ana bdabt)
    }
}
---
require_once 'Fruit.php';
OR 
$fruit = new Fruit();
---
$fruit-> setname('foouad')
$fruit->setpass("546444654");
echo $fruit->getname()
------constructeur:
public function __construct()

------destruct:
b7aali katvide lmemoire mn daak lobject likryitih fax makatb9axx m7tajo 


------incapsulation:
homa public private protected

-*------------statique 
public static $propriete = 0 ;
-- bax t3ayliha 
self::$propriete 
-- bara class
class::propriete

--------------heritage 
require 'utilisateur.php'
class admin extends utilisateur(

)

------------surchage 
howa nafss les methodes 3andom nafs smya walakin traritement mbdl mli kat herite dak lmethod mn class akhra
function getnom(){
    parent::methode()
}


----------le mocle >>> final 
hadii labriti t9ol had method wla had class maytheritaxe 

--------- readonly
kadira f dok les variable likadiklarihoom flewel 

-------- magic



-----------------------------------METHOD MAGIC---------------------------------------------------------------------------------------
1. __set()
haddi b7aali katala3lk wa7dd lmessage mli makil9aaxwa7dd variaable matalan ana 3aayt lwaa7d lvariable ida makanxx normaalement raytlaa3lk error walakin m3a set la rat9adlk waa7d wa7d lmessage liradiro nta fwestt had set 
***************************************************************************************************************************************************************************************************************************  
2. __isset() 

 katxoof wax dak eleement  mdiclari f class wla o wax 3aamr wla la 
***************************************************************************************************************************************************************************************************************************
3. __unset() 
 
***************************************************************************************************************************************************************************************************************************
4. __sleep() 

***************************************************************************************************************************************************************************************************************************
5. __serialize() 
magic/>>> mohimm haddi dyaal xi stockage kifaxx tsocker dok les info  mn baa3d mli kat3aaytlihaa bra lclass ida makntixx drti had __sir.. raytlaa3lk bwaa7d l form o ida drtiha raytlaa3lk bxkll li drtiih f dak methodd magic 
db hadii katrddlk dak obj string
***************************************************************************************************************************************************************************************************************************
6. __sleep() 

**************************************************************************************************************************************************************************************************************************
7. __wakeup() 

***************************************************************************************************************************************************************************************************************************
8. __unserialize() 
haddi ratrdlk daak xi lijjbtiih b serialize lewwla katrdoo tableau baxx mli t3aaaytliha f class   radii thzz dak lobject oradii tstokih f data base 
***************************************************************************************************************************************************************************************************************************
9. __call() 
haddi b7aal callstatic rir hya maxi function static 
***************************************************************************************************************************************************************************************************************************
10. __callStatic() 
haddi b7aal set rir hya katkhdmm 3la les fonction 
***************************************************************************************************************************************************************************************************************************
11. __toString() 
 haddi b7aal xi method dyalm affichage ewa mn baa3d kadiir echo dak lclass oraytla3lk dakxi liradi tkon, ktbtih f method __tostring
***************************************************************************************************************************************************************************************************************************
12. __invoke() 
haddi kat7awwl obj l function 
***************************************************************************************************************************************************************************************************************************
13. __set_state() 
 
***************************************************************************************************************************************************************************************************************************
14. __clone()
 
***************************************************************************************************************************************************************************************************************************

php rankhadlm fih mysql 

--------------------------------------------RELATION AVEC BASE DE DONNES----------------------------------------------------

$serveurname = 'localhost' hadi dima 3andna fhaad l7ala dyalna 

$username ='root'
$password = "cmc2024"
creation du conixion : 
try{
    

$conn = new PDO("mysql:host=$serveurname;dbname=smya dyaal base de donnes" , $username , $password);

---- dab tkoniktina :

test bax nxof w&ax khdm wla la :
$conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION)
}
catch(PDOException $err){
    echo $err->getMessage();
}

$conn =null; hna sadina conixion



----------------------------------------------------------20/05/20225
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////
$_POST/ $_GET == katkhdm bihom 3la 7asaab lmethod lidrti f balise form ida drti get okhdmùti bl post raytala3lk error 
walakin kayna waa7d l9adya lihya $_REQUEST hadii la ida khdmti biha hya maxi so9a wax nta khdmti bl post get ...

$nom = $_POST["nom"]
$pre = $_POST["prenom"]
//---------

 
- redirection hya kidir mn page dyal login l page dyal accueil ==> okadirha b  header("location:form-merci.html") 

- labriti tkhddm bxi fichier (matalan : json , image , video , txt ) katziid wa7dd l3iba smitha enctype="multipart/form-data" whadi kat7ta fl form  
whaad lfichier utilisateu rhopwa liradi idakhalaha 

- variable superglobale $_SERVER['request_method']==> hadii katjiblk lmethod liknti drti flmethod wax get wla post 
$x = $_SERVER['PHP_SELF'];hadi katjiblk cemùauin li flaction 
$xy= $_SERVER['REMOTE_ADDR'];hadi kat3tik adresse
obaa9i .... 

$_ENV ==> hadi katsta3ml flaravelle  okatkhazzn fiha dok 
$_cookies / $_session ==> 
//////////////////////////////////////////////////////////////////////////////////////////////
---------------------------------------------fichier-------------------------------------------------
$fichier = fopen('fichier.txt','r'); r+ ==> t9ra + tktb 
a ==> tktb bla matmssa7 w ida makanx ktcree , a+ == > kat9ra wtktb w ida makanx ktcree 
w ==> ratcree ida makanx ficjier  ida kan kayyn ratmsaa7 lcontenue 

bax t9raa fichier :
-- $allcontent = fread($fichier , filesize('fichier.txt')) had fielsize ==  9ra fichier kolo ,,,, ida drtii ra9mm hnaa kiyakhood octé ya3ni 5 co dyal les donnes
    or file('fichier')
-- $staaarlewle = fgets($fichier); /// fgetc hadi katjiblk car b cara 
-- fclose($fichier);
-- feof($) ????
-- frwrite($fichier , $text) hadi rh katajouter m3a akhiir caractere ya3ni maxii katnaa9azz star o3ad katktb  -- 
-- fseek($fichier , kadir hna mnin briti tbda ktaba okadir ra9mm )
-$_FILES
bax tenregetre 
$_FILES['nom de la varible']['name katb9a haka ']

//////////////////////////////////////////////////////////////////////////////////////////////
----------------------------------------------POO--------------------------------------------------------
class Fruit{
    // les method (propriete)
    private $oooo; 

    public function ***($name){
        $this -> username =  $name ; // this(z3ma fin ana bdabt)
    }
}
---
require_once 'Fruit.php';
OR 
$fruit = new Fruit();
---
$fruit-> setname('foouad')
$fruit->setpass("546444654");
echo $fruit->getname()
------constructeur:
public function __construct()

------destruct:
b7aali katvide lmemoire mn daak lobject likryitih fax makatb9axx m7tajo 


------incapsulation:
homa public private protected

-*------------statique 
public static $propriete = 0 ;
-- bax t3ayliha 
self::$propriete 
-- bara class
class::propriete

--------------heritage 
require 'utilisateur.php'
class admin extends utilisateur(

)

------------surchage 
howa nafss les methodes 3andom nafs smya walakin traritement mbdl mli kat herite dak lmethod mn class akhra
function getnom(){
    parent::methode()
}


----------le mocle >>> final 
hadii labriti t9ol had method wla had class maytheritaxe 

--------- readonly
kadira f dok les variable likadiklarihoom flewel 

-------- magic










-----------------------------------METHOD MAGIC---------------------------------------------------------------------------------------
1. __set()
haddi b7aali katala3lk wa7dd lmessage mli makil9aaxwa7dd variaable matalan ana 3aayt lwaa7d lvariable ida makanxx normaalement raytlaa3lk error walakin m3a set la rat9adlk waa7d wa7d lmessage liradiro nta fwestt had set 
***************************************************************************************************************************************************************************************************************************  
2. __isset() 

 katxoof wax dak eleement  mdiclari f class wla o wax 3aamr wla la 
***************************************************************************************************************************************************************************************************************************
3. __unset() 
 
***************************************************************************************************************************************************************************************************************************
4. __sleep() 

***************************************************************************************************************************************************************************************************************************
5. __serialize() 
magic/>>> mohimm haddi dyaal xi stockage kifaxx tsocker dok les info  mn baa3d mli kat3aaytlihaa bra lclass ida makntixx drti had __sir.. raytlaa3lk bwaa7d l form o ida drtiha raytlaa3lk bxkll li drtiih f dak methodd magic 
db hadii katrddlk dak obj string
***************************************************************************************************************************************************************************************************************************
6. __sleep() 

**************************************************************************************************************************************************************************************************************************
7. __wakeup() 

***************************************************************************************************************************************************************************************************************************
8. __unserialize() 
haddi ratrdlk daak xi lijjbtiih b serialize lewwla katrdoo tableau baxx mli t3aaaytliha f class   radii thzz dak lobject oradii tstokih f data base 
***************************************************************************************************************************************************************************************************************************
9. __call() 
haddi b7aal callstatic rir hya maxi function static 
***************************************************************************************************************************************************************************************************************************
10. __callStatic() 
haddi b7aal set rir hya katkhdmm 3la les fonction 
***************************************************************************************************************************************************************************************************************************
11. __toString() 
 haddi b7aal xi method dyalm affichage ewa mn baa3d kadiir echo dak lclass oraytla3lk dakxi liradi tkon, ktbtih f method __tostring
***************************************************************************************************************************************************************************************************************************
12. __invoke() 
haddi kat7awwl obj l function 
***************************************************************************************************************************************************************************************************************************
13. __set_state() 
 
***************************************************************************************************************************************************************************************************************************
14. __clone()
 
***************************************************************************************************************************************************************************************************************************

php rankhadlm fih mysql 

--------------------------------------------RELATION AVEC BASE DE DONNES----------------------------------------------------
$serveurname = 'localhost' hadi dima 3andna fhaad l7ala dyalna 

$username ='root'
$password = "cmc2024"
creation du conixion : 
try{
    
$conn = new PDO("mysql:host=$serveurname;dbname=smya dyaal base de donnes" , $username , $password);
---- dab tkoniktina 

test bax nxof w&ax khdm wla la :
$conn->setAttribute(PDO::ATTR,PDO::ERRMODE_EXCEPTION)
}
catch(PDOException $err){
    echo $err->getMessage();
}

$conn =null; hna sadina conixion
-----isert:
$ins = "INSERT INTO testophp (nom,pre)values('fouad','bekkali')";
$conn->exec($ins);
echo "valide";


-----begintransaction
hadi bax mli t7tt cod dyaalk madkhool 7taa dir  comit
ex 
try{
conn->begintransaction();
$ins = "INSERT INTO testophp (nom,pre)values('fouad' , 'bekkali')";
$conn->exec($ins);
echo "valide";

conn->comit();
}catch(PDOException $err){
    if($conn->begintransaction()){$conn->rollback}
}


EXEMPLE:

$serveurname = 'localhost' ; // hadi dima 3andna fhaad l7ala dyalna 

$username ="root" ;
$password = "cmc2024"; 
// creation du conixion : 
// try{
 try{   
$conn = new PDO("mysql:host=$serveurname;dbname=exemple_db" , $username , $password);
// // ---- dab tkoniktina 
// echo $serveurname ."<br>",$username."<br>",$password ; 
// // test bax nxof w&ax khdm wla la :
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// echo "testtt ";
// $ins = "INSERT INTO testophp (nom,pre)values('fouad','bekkali')";
// $conn->exec($ins);
// echo "valide";

    $conn->beginTransaction();
    $ins = "INSERT INTO testophp (nom,pre)values('fouad' ,'bekkali' )";
    $conn->exec($ins);
    $inss = "INSERT INTO testophp (nom,pre)values('hamza')";
    $conn->exec($inss);

    echo "valide";
    
    $conn->commit();
    echo "valideeee";
    }catch(PDOException $err){
        if($conn->inTransaction()){$conn->rollBack(); echo"yess";}echo"error : " . $err.getMessage() ;
    }





---------------prepare:
$ins = "INSERT INTO testophp (nom,pre)values(:nom , :pre)";
$stmt = $conn->prepare($ins);

$nom="brik";$pre="bkk"
$stmt->bindParam(':nom',$nom)
$stmt->bindParam(':pre',$pre)

$stmt->execute();

momkin dir nixan $stmt->execute([':nom' => 'ahmed' , ':pre' => 'bekk'])

----------------update
$up = $conn->prepare("UPDATE table SET nom = :nom where pre = :pre")
$up->execute([':nom' => 'newnom' , ':pre' => 'bekk'])

---------------Delete
$del = "DELETE FROM table where pre= :pre";
$dell =$conn->prepare($del);
$pre = "bkk";
$dell->execute([':pre' => $pre])

------------------select 

$select = $conn->prepare("select pre , nom  from testophp")
$select->execute();

$result = $select->fetchAll(PDO::FETCH_ASSOC);
print_r($result)













?>
</body>
</html>

?>
</body>
</html>

