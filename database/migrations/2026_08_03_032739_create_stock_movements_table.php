public function up(): void
{
    Schema::create('stock_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('store_id')->constrained()->cascadeOnDelete();
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->enum('type', ['in', 'out']);
        $table->unsignedInteger('quantity');
        $table->string('reason')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('stock_movements');
}