
<?php

class Game {
    private $id;
    private $title;
    private $genre;
    private $platform;
    private $release_year;
    private $rating;
    private $price;
    private $image;

    public function __construct($id, $image, $title, $genre, $platform, $release_year, $rating, $price) {
        $this->id = $id;
        $this->image = $image;
        $this->title = $title;
        $this->genre = $genre;
        $this->platform = $platform;
        $this->release_year = $release_year;
        $this->rating = $rating;
        $this->price = $price;
    }

    public function getID() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setGenre($genre) {
        $this->genre = $genre;
    }
    public function getGenre() {
        return $this->genre;
    }
                
    public function setPlatform($platform) {
        $this->platform = $platform;
    }
    public function getPlatform() {
        return $this->platform;
    }
                        
    public function setRelease_year($release_year) {
        $this->release_year = $release_year;
    }
    public function getRelease_year() {
        return $this->release_year;
    }
                        
    public function setRating($rating) {
        $this->rating = $rating;
    }
    public function getRating() {
        return $this->rating;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    public function getPrice() {
        return $this->price;
    }

    public function setImage($image) {
        $this->image = $image;
    }
    public function getImage() {
        return $this->image;
    }
}
    
?>