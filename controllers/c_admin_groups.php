<?php
// c_admin_groups.php
session_start();
/*
Récupérer les fonctions communes à toutes les pages
*/

require_once ("../models/functions.php");
require_once ("../models/admin.php");



checkConnection();
checkPermissions($_SESSION["user"]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $action = $data['action'];
    $group = $data['group'] ?? null;
    $category = $data['category'] ?? null;

    $jsonFileGroups = "../assets/tempgroups.json";
    $groups = json_decode(file_get_contents($jsonFileGroups), true);

    $jsonFileUsers = "../assets/tempusers.json";
    $users = json_decode(file_get_contents($jsonFileUsers), true);

    if ($action === 'add') {
        if ($group && $category && isset($groups[$group])) {
            if (!in_array($category, $groups[$group]['categories_interdites'])) {
                $groups[$group]['categories_interdites'][] = $category;
                file_put_contents($jsonFileGroups, json_encode($groups, JSON_PRETTY_PRINT));
                echo json_encode(['success' => true, 'message' => 'Category added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Category already exists']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid group or category']);
        }
    } elseif ($action === 'remove') {
        if ($group && $category && isset($groups[$group])) {
            if (in_array($category, $groups[$group]['categories_interdites'])) {
                $groups[$group]['categories_interdites'] = array_diff($groups[$group]['categories_interdites'], [$category]);
                file_put_contents($jsonFileGroups, json_encode($groups, JSON_PRETTY_PRINT));
                echo json_encode(['success' => true, 'message' => 'Category removed successfully']);
    
                $jsonFileUsers = "../assets/tempusers.json";
                $users = json_decode(file_get_contents($jsonFileUsers), true);
    
                foreach ($users as &$user) {
                    if (isset($user['groupes']) && is_array($user['groupes']) && in_array($group, $user['groupes'])) {
                        $key = array_search($category, $user['groupes']);
                        if ($key !== false) {
                            unset($user['groupes'][$key]);
                            $user['groupes'] = array_values($user['groupes']);
                        }
                    }
                }
    
                file_put_contents($jsonFileUsers, json_encode($users, JSON_PRETTY_PRINT));
    
            } else {
                echo json_encode(['success' => false, 'message' => 'Category not found']);
            }
        }
        } elseif ($action === 'deleteGroup') {
        if ($group && isset($groups[$group])) {
            unset($groups[$group]);

            // Update users to remove the deleted group
            foreach ($users as &$user) {
                if (isset($user['group']) && $user['group'] === $group) {
                    unset($user['group']);
                }
            }

            file_put_contents($jsonFileGroups, json_encode($groups, JSON_PRETTY_PRINT));
            file_put_contents($jsonFileUsers, json_encode($users, JSON_PRETTY_PRINT));
            
            echo json_encode(['success' => true, 'message' => 'Group deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Group not found']);
        }
    } elseif ($action === 'createGroup') {
        if ($group) {
            if (isset($groups[$group])) {
                echo json_encode(['success' => false, 'message' => 'Group already exists']);
            } else {
                $groups[$group] = ['categories_interdites' => []];
                file_put_contents($jsonFileGroups, json_encode($groups, JSON_PRETTY_PRINT));
                echo json_encode(['success' => true, 'message' => 'Group created successfully']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid group name']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
