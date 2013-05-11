BarTab::Application.routes.draw do

  resources :cases


  resources :clients do
    resources :cases do
      post '/invoice' => 'cases#invoice'
      get  '/invoice/:invoice_id' => 'cases#show_invoice'
    end
  end


  devise_for :users

  root to: 'home#index'
end
