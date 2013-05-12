class Case < ActiveRecord::Base
  attr_accessible :client_id, :notes, :name

  belongs_to :client
end
