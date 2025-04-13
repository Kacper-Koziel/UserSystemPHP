<?php    

    enum SystemRole: string {
        case None = 'None';
        case Admin = 'Admin';
        case Moderator = 'Moderator';
        case Helper = 'Helper';
        case Owner = 'Owner';
    }
    

    class User 
    {
        //Pole statyczne klasy
        public static $userCount = 0;

        //Pola z wartościami domyślnymi
        public $ID = 0;
        protected $password = "N/A";
        protected $name = "N/A";
        protected $permissionLevel = 0;
        protected $role = SystemRole::None;

        protected $contacts = [];
        protected $groups = [];
        protected $messagesRecieved = [];
        protected $blockedUsers = [];

        //Konstruktory
        public function __construct($pName, $pPassword, $pRole = 'None', $pPerm = 1, $pID = null)
        {
            $this->ID = $pID ? $pID : User::$userCount + 1;
            $this->password = $pPassword;
            $this->name = $pName;
            $this->permissionLevel = $pPerm;
            $this->role = is_string($pRole) ? SystemRole::from($pRole) : $pRole;
            self::$userCount++;
        }

        //Gettery
        public function getPassword()
        {
            return $this->password;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getPermissionLevel()
        {
            return $this->permissionLevel;
        }

        public function getRole()
        {
            return $this->role;
        }

        //Settery
        public function setPassword($newPassword)
        {
            $this->password = $newPassword;
        }
    
        public function setName($newName)
        {
            $this->name = $newName;
        }
    
        public function setPermissionLevel($newLevel)
        {
            $this->permissionLevel = $newLevel;
        }

        public function setRole($newRole)
        {
            $this->role = $newRole;
        }

        public function getContacts()
        {
            return $this->contacts;
        }

        public function getGroups()
        {
            return $this->groups;
        }

        public function getMessages()
        {
            return $this->messagesRecieved;
        }

        public function addMessage($newMessage)
        {
            $this->messagesRecieved[] = $newMessage;
        }

        public function getBlockedUsers()
        {
            return $this->blockedUsers;
        }

        public function isBlocked($userID)
        {
            foreach($this->blockedUsers as $id)
            {
                if($id == $userID)
                {
                    return true;
                }
            }

            return false;
        }

        public function blockUser($userID)
        {
            $this->blockedUsers[] = $userID;
        }

        public function unlockUser($userIndex)
        {
            array_splice($this->blockedUsers, $userIndex, 1);
        }

        public function addContact($contact)
        {
            $this->contacts[] = $contact;
        }

        public function deleteContact($index)
        {
            array_splice($this->contacts, $index, 1);
        }

        public function synchronizeContact($index, $synContact)
        {
            $this->contacts[$index] = $synContact;
        }

        public function getContact($index)
        {
            return $this->contacts[$index];
        }

        public function getGroup($index)
        {
            return $this->groups[$index];
        }

        public function addGroup($group)
        {
            $this->groups[] = $group;
        }

        public function deleteGroup($index)
        {
            array_splice($this->groups, $index, 1);
        }
    }

    class Admin extends User 
    {
        //Pola statyczne
        public static $adminsCount = 0;

        //Nadpisane wartości domyślne
        protected $permissionLevel = 3;
        protected $role = SystemRole::Admin;

        //Konstruktor
        public function __construct($pName, $pPassword, $pRole = 'Admin', $pPerm = 3, $pID = null)
        {
            parent::__construct($pName, $pPassword, $pRole, $pPerm, $pID);
            self::$adminsCount++;
        }
    }

    class Moderator extends User {
        //Pola statyczne
        public static $moderatorsCount = 0;

        //Nadpisane wartości domyślne
        protected $permissionLevel = 2;
        protected $role = SystemRole::Moderator;

        //Konstruktor
        public function __construct($pName, $pPassword, $pRole = 'Moderator', $pPerm = 2, $pID = null)
        {
            parent::__construct($pName, $pPassword, $pRole, $pPerm, $pID);
            self::$moderatorsCount++;
        }
    }

    class Message {
        public static $msgCount = 0;
        public $ID;
        protected $senderID;
        protected $text;
        public $hasBeenSeen = false;
        public $parentsName = null;
    
        public function __construct($pSenderID, $pText, $pParentsName, $pID = null)
        {
            $this->ID = $pID ? $pID : self::$msgCount + 1;
            $this->senderID = $pSenderID;
            $this->text = $pText;
            $this->parentsName = $pParentsName;
            self::$msgCount++;
        }
    
        public function getSenderID()
        {
            return $this->senderID;
        }
    
        public function getText()
        {
            return $this->text;
        }
    
        public function setText($pText)
        {
            $this->text = $pText;
        }
    }
    

    class Contact {
        public static $contactCount = 0;
        public $ID;
        protected $firstUserID;
        protected $secondUserID;
        protected $messages = [];
        public $name;

        public function __construct($pFirstUserID, $pSecondUserID, $pName, $pID = null)
        {
            self::$contactCount = isset($_SESSION['contactsCount']) ? $_SESSION['contactsCount'] : 0;
            $this->ID = $pID ? $pID : Contact::$contactCount;
            $this->firstUserID = $pFirstUserID;
            $this->secondUserID = $pSecondUserID;
            $this->name = $pName;
        }

        public function isMember($user)
        {
            return $firstUser->ID == $user->ID || $secondUser->ID == $user->ID;
        }

        public function getFirstUserID()
        {
            return $this->firstUserID;
        }

        public function getSecondUserID()
        {
            return $this->secondUserID;
        }
        
        public function getMessages()
        {
            return $this->messages;
        }

        public function addMessage($message)
        {
            $this->messages[] = $message;

        }

        
    }

    class Group {
        public static $groupCount = 0;
        public $ID;
        protected $membersIDs = [];
        protected $messages = [];
        public $name;


        public function __construct($pMembersIDs, $pName, $pID = null)
        {
            self::$groupCount = isset($_SESSION['groupsCount']) ? $_SESSION['groupsCount'] : 0;
            $this->ID = $pID ? $pID : Group::$groupCount + 1;
            $this->membersIDs = $pMembersIDs;
            $this->name = $pName;
        }

        public function getMembersIDs()
        {
            return $this->membersIDs;
        }


        public function getMessages()
        {
            return $this->messages;
        }
        
        public function addMessage($message)
        {
            $this->messages[] = $message;

        }

        public function addMemberID($id)
        {
            $this->membersIDs[] = $id;
        }

        public function isMember($pMemberID)
        {
            foreach ($this->membersIDs as $memberID)
            {
                if ($memberID == $pMemberID)
                {
                    return true;
                }
            }

            return false;
        }

        public function deleteMember($id, $uDatabase)
        {
            $index = null;

            for ($i = 0; $i < count($this->membersIDs); $i++) 
            { 
                $user = $uDatabase[$this->membersIDs[$i] - 1];
                if ($user->ID == $id)
                {
                    $index = $i;
                    break; 
                }
            }

            if ($index !== null)
            {
                array_splice($this->membersIDs, $index, 1);
            }
        }


    }
?>