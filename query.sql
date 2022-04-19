SELECT
  *,
  COUNT(*) AS nb_cards_open
FROM
  board b
  LEFT OUTER JOIN card c ON b.id = c.board_id
WHERE
  c.is_open = 1
  AND b.is_open = 1
  AND b.room_id = 1
GROUP BY
  b.id
ORDER BY
  nb_cards_open DESC;
SELECT
  u
FROM
  User u
  JOIN u.address a
WHERE
  a.city = 'Berlin' ";

SELECT b, COUNT(*) AS nb_cards_open
FROM Board::class b 
LEFT JOIN CARD::class c ON board.id = card.board 
WHERE c.isOpen = 1 
AND b.isOpen = :state
AND b.room = :room
GROUP BY b.id
ORDER BY nb_cards_open