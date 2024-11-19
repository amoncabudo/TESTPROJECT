<?php

class Users
{
    private PDO $sql;

    public function __construct(PDO $sql)
    {
        $this->sql = $sql;
    }

    //  id_user | username | password
    public function addUser($username, $password, $email, $role)
    {
        $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $stm = $this->sql->prepare($query);
        $stm->execute([":username" => $username, ":password" => $password, ":email" => $email, ":role" => $role]);
    }

    public function getAllUsers()
    {
        $query = "SELECT id_user, username, email, role FROM users";
        $stm = $this->sql->prepare($query);
        $stm->execute();

        // Recupera todas las canciones como un arreglo asociativo
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id_user)
    {
        $query = "SELECT username, password, email, role FROM users WHERE id_user = :id_user;";
        $stm = $this->sql->prepare($query);
        $stm->execute([":id_user" => $id_user]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    //  id_user | username | password
    public function updateUser($id_user, $username, $password, $email, $role)
    {
        // Asegurarse de que todos los parámetros estén presentes en la consulta
        $query = "UPDATE users SET 
            username = :username, 
            password = :password,
            email = :email,
            role = :role
            WHERE id_user = :id_user";  // Es importante que este marcador también esté en el array

        // Preparar la consulta
        $stm = $this->sql->prepare($query);

        // Crear el array de parámetros con todos los valores necesarios
        $params = [
            ':username' => $username,
            ':password' => $password,
            ':email' => $email,
            ':role' => $role,
            ':id_user' => $id_user // Asegúrate de pasar el ID aquí
        ];

        // Ejecutar la consulta con los parámetros correctos
        $result = $stm->execute($params);

        return $result;
    }
}
