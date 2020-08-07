<?php
class Image extends Model
{
    public function create(array $form_fields)
    {

        $sql = "INSERT INTO images (file_name) VALUES (:file_name)";

        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            'file_name' => $form_fields['image']          

        ]);


    }

    

    public function showAllImages()
    {
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function showOneImage($id){
        $sql = "SELECT * FROM images WHERE id = ? ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([$id]); 
        return $req->fetch();
    }

    public function filterPurchases(array $filters){

      $conditions = [];
      $parameters = [];

      if ($filters['user_id']){

            $conditions[] = 'entry_by = ? ';
            $parameters[] = $filters['user_id'];
        }

        if ($filters['start_date'] && $filters['end_date']){

            // BETWEEN
            $conditions[] = 'entry_at BETWEEN ? AND ? ';
            $parameters[] = $filters['start_date'];
            $parameters[] = $filters['end_date'];
        }


        // the base query
        $sql = "SELECT * FROM demo_table ";


        if ($conditions)
        {
            $sql .= " WHERE ".implode(" AND ", $conditions);
        }

        $sql .= "ORDER BY id DESC";

        // die($sql);
        $req = Database::getBdd()->prepare($sql);
        $req->execute($parameters);

        return $req->fetchAll();


    }




}
?>
