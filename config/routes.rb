BarTab::Application.routes.draw do

  resources :clients


  devise_for :users

  root to: 'home#index'
end
