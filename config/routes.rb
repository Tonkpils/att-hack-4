BarTab::Application.routes.draw do

  resources :cases


  resources :clients do
    resources :cases
  end


  devise_for :users

  root to: 'home#index'
end
