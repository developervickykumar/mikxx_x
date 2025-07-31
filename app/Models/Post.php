<?php


namespace App\Models;

    class Post extends Model
    {
        protected $fillable = ['user_id', 'post_type', 'content', 'visibility'];
    
        public function user() {
            return $this->belongsTo(User::class);
        }
    
        public function image() {
            return $this->hasOne(PostImage::class);
        }
    
        public function video() {
            return $this->hasOne(PostVideo::class);
        }
    
        public function poll() {
            return $this->hasOne(PostPoll::class);
        }
    
        public function article() {
            return $this->hasOne(PostArticle::class);
        }
    
        public function tags() {
            return $this->hasMany(PostTag::class);
        }
    
        public function location() {
            return $this->hasOne(PostLocation::class);
        }
    }
    

?>