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
        $userData = $this->userModel->find($userId);

        $data = [
            'title' => 'My Collections - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'cardAlbums' => $this->cardAlbumModel->findAll()
        ];
        
        return view('pages/my_collection', $data);
    }

    public function show($id)
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        $cardAlbum = $this->cardAlbumModel->find($id);
        $cards = $this->tbCardsModel->where('album_id', $id)->first();
        if ($cards === null) {
            $cards = ['cards' => '[]']; // Provide a default empty JSON array
        }

        $data = [
            'title' => 'View Album - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'cardAlbum' => $cardAlbum,
            'cards' => $cards,
        ];
        
        return view('albums/show', $data);
    }
    

    public function create()
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        // Fetch all albums to populate the select dropdown
        $albums = $this->albumModel->findAll();

        // Prepare data to pass to the view
        $data = [
            'title' => 'Add New User Album Collection',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'albums' => $albums,
        ];

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
        print_r($cardAlbum);
        echo '<br>';
        echo '<br>';
        $album = $this->albumModel->find($cardAlbum['album_id']);
        print_r($album);
        echo '<br>';
        echo '<br>';
        $cards = $this->tbCardsModel->where('album_id', $cardAlbum['album_id'])->first();
        print_r($cards);
        echo '<br>';
        echo '<br>';
        if ($cards === null) {
            $cards = ['cards' => '']; // Provide a default empty JSON array
        }

        $data = [
            'title' => 'Edit - WebTech Admin',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'cardAlbum' => $cardAlbum,
            'albumCards' => json_decode($cards['cards']),
        ];
        echo '<br>';
        echo '<br>';
        print_r($cards['cards']);
        
        return view('albums/edit', $data);
    }
    
    public function update($id)
    {
        $data = $this->request->getPost();

        // Update the card album details
        $this->cardAlbumModel->update($id, [
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        // Check if a record exists in tb_cards with the given album_id
        $cardRecord = $this->tbCardsModel->where('album_id', $id)->first();

        // If the record exists, update it, otherwise create a new one
        if ($cardRecord) {
            $this->tbCardsModel->update($cardRecord['id'], [
                'cards' => json_encode($data['cards'])
            ]);
        } else {
            $this->tbCardsModel->insert([
                'album_id' => $id,
                'cards' => json_encode($data['cards'])
            ]);
        }

        return redirect()->to('/my-collection');
    }
    

    public function delete($id)
    {
        $this->cardAlbumModel->delete($id);
        
        return redirect()->to('/my-collection');
    }
    public function addCards()
    {
        $userId = $this->auth->id();
        $userData = $this->userModel->find($userId);

        // Fetch all albums to populate the select dropdown
        $albums = $this->albumModel->findAll();

        // If form is submitted, validate and process data
        if ($this->request->getMethod() === 'post') {
            $validationRules = [
                'album_id' => 'required|integer',
                'cards' => 'required'
            ];

            if ($this->validate($validationRules)) {
                $albumId = (int) $this->request->getPost('album_id');
                $cards = $this->request->getPost('cards');
    
                // Prepare data to insert into the tb_cards table
                $cardData = [
                    'album_id' => $albumId,
                    'cards' => json_encode(json_decode($cards))
                ];
                $album = $this->albumModel->find($albumId);

                if (!$album) {
                    // Handle case where $albumId does not exist
                    echo 'Album ID does not exist or is invalid.';
                    return; // or redirect, throw exception, etc.
                }
    
                try {
                    // Insert data into the tb_cards table and get the inserted ID
                    $cardId = $this->tbCardsModel->insert($cardData);
    
                    // Check if the insertion was successful
                    if ($cardId) {
                        // Prepare data to update the tb_album_collections table
                        $albumData = [
                            'cards_id' => $cardId
                        ];
    
                        // Update the tb_album_collections table with the cards_id
                        if ($this->albumModel->update($albumId, $albumData)) {
                            // Redirect to a success page or return a success message
                            return redirect()->to('/admin/albums')->with('success', 'Cards successfully added to an album collection!');
                        } else {
                            // Handle update failure
                            echo 'Error updating album collections!';
                        }
                    } else {
                        // Handle insertion failure
                        echo 'Error adding cards to a collection!';
                    }
                } catch (\Exception $e) {
                    // Log or output the exception message for further debugging
                    echo 'Exception: ' . $e->getMessage();
                }
            } else {
                // Handle validation errors
                echo 'Validation Error while adding cards to a collection!';
            }
        }

        // If validation fails or initial load of the form
        $data = [
            'title' => 'Add Cards to Album',
            'description' => 'This is a dynamic description for SEO',
            'userData' => $userData,
            'albums' => $albums,
            'validation' => $this->validator // Ensure $this->validator is set correctly
        ];

        return view('admin/albums/add_cards', $data);
    }

    
}
