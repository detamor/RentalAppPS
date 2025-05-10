class Order extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}