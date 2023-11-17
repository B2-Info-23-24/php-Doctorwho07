<?php

class OrdersModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }

    public function AddOrders($StartDate, $EndDate, $DateOrder, $price)
    {
        try {
            $sql = "INSERT INTO orders (Start, End, DateOrder, Price, foreign_key_property,foreign_key_user) VALUES ('$StartDate','$EndDate', '$DateOrder', '$price')";
            $this->connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function GetOrderById($OrderId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE ID = '$OrderId'";
            $userData = $this->connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
    public function GetAllOrders()
    {
        try {
            $sql = "SELECT * FROM Orders";
            $userList = $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $userList !== false ? $userList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            return array();
        }
    }


    public function UpdateOrdersById($OrderId, $newOrderData)
    {
        try {
            $currentUserData = $this->GetOrderById($OrderId);
            if ($currentUserData) {
                foreach ($newOrderData as $key => $value) {
                    $currentUserData[$key] = $value;
                }
                $sql = "UPDATE orders SET ";
                foreach ($currentUserData as $key => $value) {
                    $sql .= "$key = '$value', ";
                }
                $sql = rtrim($sql, ", ");
                $sql .= " WHERE ID = '$OrderId'";
                $affectedRows = $this->connexion->exec($sql);
                return $affectedRows !== false ? true : false;
            } else {
                echo "Utilisateur non trouvé.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}
