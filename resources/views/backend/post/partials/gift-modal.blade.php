<style>
        :root {
            --primary-color: #6841b7;
            --primary-hover: #5a35a0;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-full: 9999px;
        }

        .gift-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .gift-container {
            background: var(--bg-primary);
            border-radius: var(--radius-md);
            width: 100%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 1.5rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .gift-container::-webkit-scrollbar {
            display: none;
        }

        .gift-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .gift-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .gift-title .material-icons-outlined {
            font-size: 1.5rem;
        }

        .close-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
            padding: 0.5rem;
            border-radius: var(--radius-full);
            transition: all 0.2s;
        }

        .close-btn:hover {
            background: var(--bg-secondary);
            color: var(--primary-color);
        }

        .gift-categories {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .gift-categories::-webkit-scrollbar {
            display: none;
        }

        .category-btn {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            background: var(--bg-secondary);
            border: none;
            cursor: pointer;
            white-space: nowrap;
            color: var(--text-primary);
            transition: all 0.2s;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-btn:hover {
            background: var(--border-color);
        }

        .category-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .category-btn .material-icons-outlined {
            font-size: 1.25rem;
        }

        .gift-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            /*gap: 1rem;*/
            margin-bottom: 1.5rem;
            padding: 0.5rem;
        }

        .gift-item {
            background: transparent;
            border-radius: var(--radius-md);
            /*padding: 0.4rem;*/
            margin: 0.1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 50px;
            height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            /*border: 1px solid var(--border-color);*/
        }

        .gift-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-color);
        }

        .gift-item.selected {
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 0 2px rgba(104, 65, 183, 0.1);
        }

        .gift-icon {
            font-size: 2rem;
            /*margin-bottom: 0.25rem;*/
            transition: all 0.3s ease;
        }

        .gift-item:hover .gift-icon {
            transform: scale(1.1);
        }

        .gift-name {
            font-size: 0.688rem;
            color: var(--text-primary);
            margin-bottom: 1.25rem;
            font-weight: 500;
            /* white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; */
            max-width: 100%;
        }

        .gift-price {
            font-size: 0.625rem;
            color: var(--text-secondary);
            position: absolute;
            bottom: 0.25rem;
            left: 0;
            right: 0;
            text-align: center;
            padding: 0.25rem;
            background: var(--bg-secondary);
            border-radius: 0 0 var(--radius-md) var(--radius-md);
        }

        .gift-price.paid {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Remove all background colors */
        .gift-item[data-category="emotions"],
        .gift-item[data-category="food"],
        .gift-item[data-category="jewelry"],
        .gift-item[data-category="animals"],
        .gift-item[data-category="special"],
        .gift-item[data-category="apparel"] {
            background: transparent;
        }

        .gift-item[data-category="emotions"] .gift-icon,
        .gift-item[data-category="emotions"] .gift-name,
        .gift-item[data-category="food"] .gift-icon,
        .gift-item[data-category="food"] .gift-name,
        .gift-item[data-category="jewelry"] .gift-icon,
        .gift-item[data-category="jewelry"] .gift-name,
        .gift-item[data-category="animals"] .gift-icon,
        .gift-item[data-category="animals"] .gift-name,
        .gift-item[data-category="special"] .gift-icon,
        .gift-item[data-category="special"] .gift-name,
        .gift-item[data-category="apparel"] .gift-icon,
        .gift-item[data-category="apparel"] .gift-name {
            color: var(--text-primary);
        }

        .wallet-section {
            background: var(--bg-secondary);
            border-radius: var(--radius-md);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .wallet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .wallet-balance {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .add-money-btn {
            padding: 0.5rem 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-money-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .add-money-btn .material-icons-outlined {
            font-size: 1.25rem;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-option {
            background: var(--bg-secondary);
            border-radius: var(--radius-md);
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-option:hover {
            background: var(--border-color);
        }

        .payment-option.selected {
            border: 2px solid var(--primary-color);
        }

        .payment-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .payment-name {
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .gift-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .cancel-btn {
            padding: 0.75rem 1.5rem;
            background: var(--bg-secondary);
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .cancel-btn:hover {
            background: var(--border-color);
        }

        .send-gift-btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius-full);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .send-gift-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .send-gift-btn .material-icons-outlined {
            font-size: 1.25rem;
        }

        .amount-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-full);
            margin-bottom: 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .amount-input::placeholder {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .amount-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(104, 65, 183, 0.1);
        }

        .modal-backdrop.show{
            opacity: 0;
            z-index: 1;
        }
    </style>

 <!-- Trigger Button -->


 <div class="modal fade" id="giftModal" tabindex="-1" aria-labelledby="giftModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="giftModalLabel">Send Virtual Gift</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="gift-container">
                     <div class="gift-header">
                         <h2 class="gift-title">
                             <span class="material-icons-outlined">card_giftcard</span>
                             Send Virtual Gift
                         </h2>
                         <button class="close-btn" onclick="closeGiftModal()">
                             <span class="material-icons-outlined">close</span>
                         </button>
                     </div>

                     <div class="wallet-section">
                         <div class="wallet-header">
                             <div>
                                 <div style="font-size: 0.875rem; color: var(--text-secondary);">Wallet Balance</div>
                                 <div class="wallet-balance">$50.00</div>
                             </div>
                             <button class="add-money-btn" onclick="showAddMoney()">
                                 <span class="material-icons-outlined">add</span>
                                 Add Money
                             </button>
                         </div>
                     </div>

                     @php 
                    use App\Models\Category;
                    $giftCategories = Category::where('parent_id', 59533)->get();
                    @endphp
                   <!-- Tabs for Categories -->
                    <ul class="nav nav-tabs flex-nowrap overflow-y-auto scroll-y-custom" id="giftCategoryTabs" role="tablist">
                        @foreach($giftCategories as $index => $category)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2 @if($index === 0) active @endif"
                                    id="tab-{{ $category->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#category-{{ $category->id }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="category-{{ $category->id }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                
                                <img src="{{ asset('storage/category/images/' . $category->image) }}"
                                     alt="{{ $category->name }}"
                                     style="max-width: 30px; height: 30px; object-fit: cover; border-radius: 50%;">
                                
                                <!--<span>{{ $category->name }}</span>-->
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Tab Panes -->
                    <div class="tab-content mt-3" id="giftTabContent">
                        @foreach($giftCategories as $index => $category)
                        <div class="tab-pane fade @if($index === 0) show active @endif"
                             id="category-{{ $category->id }}"
                             role="tabpanel"
                             aria-labelledby="tab-{{ $category->id }}">
                    
                            @php  
                            $giftItems = Category::where('parent_id', $category->id)->orderBy('position')->get();

                            @endphp
                    
                            @php  
                            $giftItems = Category::where('parent_id', $category->id)->get();
                            @endphp
                            
                            <div class="gift-grid">
                                @foreach($giftItems as $giftItem)
                                    @php
                                        $priceList = $giftItem->price_list ? json_decode($giftItem->price_list, true) : null;
                                        $priceValue = $priceList['value'] ?? 0;
                                    @endphp
                            
                                    <div class="gift-item {{ ($priceValue > 0) ? 'flip-container' : '' }}" onclick="selectGift(this, {{ $giftItem->id }})" data-gift-id="{{ $giftItem->id }}">
                                        <div class="flipper">
                                            <!-- Front -->
                                            <div class="front">
                                                <img src="{{ asset('storage/category/images/' . $giftItem->image) }}"
                                                     alt=""
                                                     style="width: 100%; height: 100%; object-fit: contain;">
                                            </div>
                            
                                            <!-- Back (only if price exists) -->
                                            @if($priceValue > 0)
                                                <div class="back d-flex align-items-center justify-content-center">
                                                    <div class="text-center">
                                                        <strong>{{ $priceValue }}</strong>
                                                        <span>
    {{ isset($priceList['value_type']) && $priceList['value_type'] == 'money' ? '₹' : 'Coins' }}
</span>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        @endforeach
                    </div>

                 </div>
             </div>
             <div class="modal-footer">
                 <input type="hidden" id="gift-receiver-id">
                <input type="hidden" id="gift-post-id">
                <input type="hidden" id="gift-gift-id">

                 <button class="modal-button secondary">Cancel</button>
                 <button class="modal-button primary" onclick="sendGift()">
                     <span class="material-icons-outlined">send</span> Send Gift
                 </button>
             </div>
         </div>
     </div>
 </div>
 
 <style>
     .gift-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

 

.flipper {
    width: 100%;
    height: 100%;
    transition: transform 0.6s;
    transform-style: preserve-3d;
    position: relative;
}

.flip-container:hover .flipper {
    transform: rotateY(180deg);
}

.front, .back {
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
}

.back {
    background:#f0ad40;
    padding: 2px;
    transform: rotateY(180deg);
}

 </style>

<script>
    function selectGift(el, giftId) {
    document.querySelectorAll('.gift-item').forEach(item => item.classList.remove('selected'));
    el.classList.add('selected');

    const giftIndex = el.getAttribute('data-gift-id');
    document.getElementById('gift-gift-id').value = giftIndex;
}
</script>