class Client < ActiveRecord::Base
  attr_accessible :email, :name, :phone_number, :user_id

  belongs_to :user
  has_many :cases
end
