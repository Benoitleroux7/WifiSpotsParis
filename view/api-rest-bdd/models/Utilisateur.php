<?php
class Utilisateur{
    // Connexion
    private $connexion;
    private $table = "table_utilisateur";

    // object properties
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $image_profil;
    public $password;
    public $district;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des Utilisateur
     *
     * @return void
     */
    public function lire(){
        // On écrit la requête
        $sql = "SELECT  p.id, p.nom, p.prenom, p.email, p.image_profil, p.district FROM " . $this->table . " p  ORDER BY p.district ASC";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Créer un produit
     *
     * @return void
     */
    public function creer(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, prenom=:prenom, email=:email, image_profil=:image_profil, password=:password, district=:district";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->prenom=htmlspecialchars(strip_tags($this->prenom));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->image_profil=htmlspecialchars(strip_tags($this->image_profil));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->district=htmlspecialchars(strip_tags($this->district));

        // Ajout des données protégées
        $query->bindParam(":nom", $this->nom);
        $query->bindParam(":prenom", $this->prenom);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":prenom", $this->prenom);
        $query->bindParam(":image_profil", $this->image_profil);
        $query->bindParam(":password", $this->password);
        $query->bindParam(":district", $this->district);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Lire un produit
     *
     * @return void
     */
    public function lireUn(){
        // On écrit la requête
        $sql = "SELECT p.id, p.nom, p.prenom, p.email, p.image_profil, p.district FROM " . $this->table . " p WHERE p.id = ? LIMIT 0,1";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->id = $row['id'];
        $this->nom = $row['nom'];
        $this->prenom = $row['prenom'];
        $this->image_profil = $row['image_profil'];
        $this->district = $row['district'];
    }

    /**
     * Supprimer un produit
     *
     * @return void
     */
    public function supprimer(){
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare( $sql );

        // On sécurise les données
        $this->id=htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        if($query->execute()){
            return true;
        }
        
        return false;
    }

    /**
     * Mettre à jour un produit
     *
     * @return void
     */
    public function modifier(){
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom=:nom, prenom=:prenom, email=:email, image_profil=:image_profil, password=:password, district=:district WHERE id = :id";
        
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        
        // On sécurise les données
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->prenom=htmlspecialchars(strip_tags($this->prenom));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->image_profil=htmlspecialchars(strip_tags($this->image_profil));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->district=htmlspecialchars(strip_tags($this->district));

        // Ajout des données protégées
        $query->bindParam(":nom", $this->nom);
        $query->bindParam(":prenom", $this->prenom);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":prenom", $this->prenom);
        $query->bindParam(":image_profil", $this->image_profil);
        $query->bindParam(":password", $this->password);
        $query->bindParam(":district", $this->district);

        // On exécute
        if($query->execute()){
            return true;
        }
        
        return false;
    }

}