<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\CardAlbumModel;
use App\Models\TbCardsModel;
use App\Models\AlbumCollectionModel;

class CardAlbumsController extends BaseController
{
    protected $userModel;
    protected $cardAlbumModel;
    protected $tbCardsModel;
    protected $albumModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->cardAlbumModel = new CardAlbumModel();
        $this->tbCardsModel = new TbCardsModel();
        $this->albumModel = new AlbumCollectionModel();
    }
    protected $format    = 'json';

    public function index()
    {
        $userId = $this->auth->id();

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'My Collections - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'cardAlbums' => $this->cardAlbumModel
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->findAll()
        ];
    
        $data = array_merge($commonData, $specificData);
        
        return view('pages/my_collection', $data);
    }

    public function show($id)
    {

        $cardAlbum = $this->cardAlbumModel->find($id);
        $cards = $this->tbCardsModel->where('album_id', $id)->first();
        if ($cards === null) {
            $cards = ['cards' => '[]']; // Provide a default empty JSON array
        }

        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'View Album - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'cardAlbum' => $cardAlbum,
            'cards' => $cards,
        ];
    
        $data = array_merge($commonData, $specificData);
        
        return view('albums/show', $data);
    }
    

    public function create()
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        // Fetch all albums to populate the select dropdown
        $albums = $this->albumModel->findAll();

        // Prepare data to pass to the view
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Add New User Album Collection',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'albums' => $albums,
        ];

        $data = array_merge($commonData, $specificData);

        // Load view for adding new user album collection
        return view('albums/add', $data);
    }

    public function store()
    {
        // Validate incoming request if needed

        // Extract data from the form
        $data = [
            'user_id' => $this->auth->id(), // Assuming you have authentication set up
            'album_id' => $this->request->getPost('album_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];
        
        // Insert data into the database
        if ($this->cardAlbumModel->insert($data)) {
            echo ('User album collection added successfully.');
        } else {
            echo ('Error creating album!');
        }

        // Redirect to a success page or back to the albums list
        // return redirect()->to('/my-collection')->with('success', 'User album collection added successfully.');
    }

    public function edit($id)
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);
        $cardAlbum = $this->cardAlbumModel->find($id);
        $albumId = $cardAlbum['album_id'];
    
        // Fetch all cards for the album
        $allCards = $this->tbCardsModel->select('id, album_id, cards')
                            ->where('album_id', $albumId)
                            ->findAll();
    
        // Decode the JSON array from the 'cards' field in the fetched album
        $selectedCards = json_decode($cardAlbum['cards'], true);
        if (is_null($selectedCards)) {
            $selectedCards = [];
        }
    
        // Decode the JSON array from the 'needed_cards' field in the fetched album
        $selectedNeededCards = json_decode($cardAlbum['needed_cards'], true);
        if (is_null($selectedNeededCards)) {
            $selectedNeededCards = [];
        }
    
        // Since allCards contains an entry with a 'cards' JSON array, decode it
        $allCardIds = [];
        if (!empty($allCards) && isset($allCards[0]['cards'])) {
            $allCardIds = json_decode($allCards[0]['cards'], true);
        }
    
        $cardsForView = [];
        $neededCardsForView = [];
        foreach ($allCardIds as $cardId) {
            $cardsForView[] = [
                'id' => $cardId,
                'selected' => in_array($cardId, $selectedCards)
            ];
            $neededCardsForView[] = [
                'id' => $cardId,
                'selected' => in_array($cardId, $selectedNeededCards)
            ];
        }

        // Prepare data to pass to the view
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Edit - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'cardAlbum' => $cardAlbum,
            'albumCards' => $cardsForView,
            'neededAlbumCards' => $neededCardsForView, // Add needed cards to the view data
        ];

        $data = array_merge($commonData, $specificData);
    
        return view('albums/edit', $data);
    }
    
    public function update($id)
    {
        $data = $this->request->getPost();

        // Update the card album details
        $this->cardAlbumModel->update($id, [
            'title' => $data['title'],
            'description' => $data['description'],
            'cards' => json_encode($data['cards']),
            'needed_cards' => json_encode($data['needed_cards']) // Assuming $data['needed_cards'] contains valid JSON string
        ]);

        // Check if a record exists in tb_cards with the given album_id
        // $cardRecord = $this->tbCardsModel->where('album_id', $id)->first();

        // // If the record exists, update it, otherwise create a new one
        // if ($cardRecord) {
        //     $this->tbCardsModel->update($cardRecord['id'], [
        //         'cards' => json_encode($data['cards'])
        //     ]);
        // } else {
        //     $this->tbCardsModel->insert([
        //         'album_id' => $id,
        //         'cards' => json_encode($data['cards'])
        //     ]);
        // }

        return redirect()->to('/my-collection');
    }
    
    public function delete($id)
    {

        // Cascading Deletes or Status Updates: When an album is deleted, automatically delete or update the status of any related exchange requests to reflect that the album is no longer available. This could involve setting the exchange request's status to "cancelled" or "invalid".

        // Notification System: Notify both the sender and receiver of the exchange request about the deletion of the album. This could be done via email, in-app notifications, or both, informing them that the exchange cannot proceed due to the album's deletion.

        // Data Integrity Checks: Before performing any operations related to an exchange request (e.g., viewing, accepting, completing), verify the existence and availability of the related albums. If an album involved in the request is missing, handle the situation appropriately (e.g., by displaying a message to the user or automatically cancelling the request).

        // Archival Instead of Deletion: Instead of permanently deleting albums, consider marking them as "archived" or "inactive". This way, the data remains intact for historical or auditing purposes, and the system can easily identify and handle exchange requests involving archived albums.

        // User Confirmation: Before allowing a user to delete an album, check if there are any pending exchange requests involving that album. Prompt the user with a confirmation dialog explaining the consequences of the deletion on pending exchanges and require explicit confirmation to proceed.
        
        // Update the status of the album to 'archived'
        $this->cardAlbumModel->update($id, ['status' => 'archived']);
        
        return redirect()->to('/my-collection');
    }
    public function findCardExchanges($albumId) {
        $currentUser = $this->auth->id();
        $currentUserAlbum = $this->cardAlbumModel->where('album_id', $albumId)->where('user_id', $currentUser)->first();
    
        $currentUserNeededCards = json_decode($currentUserAlbum['needed_cards'], true) ?: [];
        $currentUserDuplicateCards = json_decode($currentUserAlbum['cards'], true) ?: [];
    
        $potentialExchanges = [];
        $allOtherUsersAlbums = $this->cardAlbumModel->where('album_id', $albumId)->where('user_id !=', $currentUser)->findAll();
    
        foreach ($allOtherUsersAlbums as $userAlbum) {
            $userNeededCards = json_decode($userAlbum['needed_cards'], true) ?: [];
            $userDuplicateCards = json_decode($userAlbum['cards'], true) ?: [];
    
            $matchesForCurrentUser = array_intersect($currentUserNeededCards, $userDuplicateCards);
            $matchesForOtherUser = array_intersect($userNeededCards, $currentUserDuplicateCards);
    
            if (!empty($matchesForCurrentUser) || !empty($matchesForOtherUser)) {
                $potentialExchanges[] = [
                    'user_id' => $userAlbum['user_id'],
                    'matchesForCurrentUser' => $matchesForCurrentUser,
                    'matchesForOtherUser' => $matchesForOtherUser,
                    'sendRequestUrl' => site_url('exchange/sendRequest/' . $userAlbum['user_id']), // Example action URL
                ];
            }
        }
    
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Potential Card Exchanges - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'potentialExchanges' => $potentialExchanges,
            'currentUser' => $currentUser,
            'albumId' => $albumId
        ];
    
        $data = array_merge($commonData, $specificData);
    
        return view('albums/exchange', $data);
    }
    public function findAllCardExchanges() {
        $currentUser = $this->auth->id();
        // Fetch all albums for the current user with album names
        $currentUserAlbums = $this->cardAlbumModel
            ->select('card_albums.*, tb_album_collections.title as album_name')
            ->join('tb_album_collections', 'tb_album_collections.id = card_albums.album_id')
            ->where('card_albums.user_id', $currentUser)
            ->findAll();
    
        $potentialExchanges = [];
    
        foreach ($currentUserAlbums as $currentUserAlbum) {
            $currentUserNeededCards = json_decode($currentUserAlbum['needed_cards'], true) ?: [];
            $currentUserDuplicateCards = json_decode($currentUserAlbum['cards'], true) ?: [];
    
            // Fetch all other users' albums except the current user's for the same album_id, including user names and album names
            $allOtherUsersAlbums = $this->cardAlbumModel
                ->select('card_albums.*, users.first_name, users.last_name, tb_album_collections.title as album_name')
                ->join('users', 'users.id = card_albums.user_id')
                ->join('tb_album_collections', 'tb_album_collections.id = card_albums.album_id')
                ->where('card_albums.album_id', $currentUserAlbum['album_id'])
                ->where('card_albums.user_id !=', $currentUser)
                ->findAll();
    
            foreach ($allOtherUsersAlbums as $userAlbum) {
                $userNeededCards = json_decode($userAlbum['needed_cards'], true) ?: [];
                $userDuplicateCards = json_decode($userAlbum['cards'], true) ?: [];
    
                $matchesForCurrentUser = array_intersect($currentUserNeededCards, $userDuplicateCards);
                $matchesForOtherUser = array_intersect($userNeededCards, $currentUserDuplicateCards);
    
                if (!empty($matchesForCurrentUser) || !empty($matchesForOtherUser)) {
                    $potentialExchanges[] = [
                        'user_id' => $userAlbum['user_id'], // Include user_id in the potential exchanges
                        'user_name' => $userAlbum['first_name'] . ' ' . $userAlbum['last_name'], // Combine first and last name
                        'album_name' => $currentUserAlbum['album_name'], // Include album name in the potential exchanges
                        'album_id' => $currentUserAlbum['album_id'], // Include album_id in the potential exchanges
                        'matchesForCurrentUser' => $matchesForCurrentUser,
                        'matchesForOtherUser' => $matchesForOtherUser,
                        'sendRequestUrl' => site_url('exchange/sendRequest/' . $userAlbum['user_id']), // Example action URL
                    ];
                }
            }
        }
    
        $commonData = $this->getCommonData();
        $specificData = [
            'title' => 'Potential Card Exchanges - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'potentialExchanges' => $potentialExchanges,
            'currentUser' => $currentUser,
        ];
    
        $data = array_merge($commonData, $specificData);
    
        return view('albums/exchanges', $data);
    }
}
