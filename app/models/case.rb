class Case < ActiveRecord::Base
  attr_accessible :client_id, :notes

  belongs_to :client
end
