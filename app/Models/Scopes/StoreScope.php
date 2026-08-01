class StoreScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check() && auth()->user()->store_id) {
            $builder->where('store_id', auth()->user()->store_id);
        }
    }
}