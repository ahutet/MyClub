<?php

namespace App\Controller\Front;

use App\Entity\Player;
use App\Entity\PlayerDetails;
use App\Entity\Team;
use App\Form\AddPlayerType;
use App\Form\PlayerDetailsType;
use App\Form\PlayerType;
use App\Form\SeasonSearchType;
use App\Form\TeamType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ManagerController extends AbstractController
{
    /**
     * @Route("/home", name="home_manager")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            return $this->render('Back/Admin/index.html.twig');

        } else {
            $options = [];
            $form = $this->createForm(SeasonSearchType::class);
            $teamRepository = $this->getDoctrine()->getRepository(Team::class);

            $club = $this->getUser()->getClub();
            $options['club'] = $club;

            if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
                $season = $form->getData()['season'];
                $options['season'] = $season;
                $teams = $teamRepository->findByClubAndSeason($options);
            } else {
                $teams = $teamRepository->findBy(['club' => $club]);
            }

            $params = [
                'form' => $form->createView(),
                'teams' => $teams,
                'club' => $club
            ];

            return $this->render('Front/Manager/index.html.twig', $params);
        }
    }

    /**
     * Création d'une équipe
     *
     * @Route("/club/edit/team", name="front_team_edit")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */

    public function newTeam(Request $request): Response
    {
        $params = [];
        $em = $this->getDoctrine()->getManager();

        $team = new Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        $params['form'] = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setClub($this->getUser()->getClub());
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('home_manager');
        }

        return $this->render('Front/Manager/editTeam.html.twig', $params);
    }

    /**
     * Ajouter un/des joueurs
     *
     * @Route("/club/team/addPlayer", name="front_add_player_team")
     *
     * @param Request $request
     * @param TeamRepository $teamRepository
     */
    public function addPlayer(Request $request, TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {
        $playerId = $request->request->get('add_player');
        $player = $playerRepository->findOneBy(['id' => $playerId['player']]);
        $teamId = $request->request->get('teamId');
        $team = $teamRepository->findOneBy(['id' => $teamId]);

        $team->addPlayer($player);
        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();

        return $this->redirectToRoute('front_team_view', ['team' => $teamId]);
    }

    /**
     * Détails d'une équipe
     *
     * @Route("/club/team/{team}", name="front_team_view")
     *
     * @param Team $team
     * @return RedirectResponse|Response
     */

    public function viewTeam(Team $team): Response
    {
        // Ajout d'un joueur
        $addPlayerForm = $this->createForm(AddPlayerType::class, null, [
            'action' => $this->generateUrl("front_add_player_team")
        ]);

        return $this->render('Front/Manager/teamDetails.html.twig', [
            'formAddPlayer' => $addPlayerForm->createView(),
            'team' => $team,
        ]);
    }

    /**
     * Création d'un joueur
     *
     * @Route("/club/edit/player", name="front_player_edit")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */

    public function newPlayer(Request $request): Response
    {
        $params = [];
        $em = $this->getDoctrine()->getManager();
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player, [
            'club' => $this->getUser()->getClub()
        ]);
        $form->handleRequest($request);

        $params['form'] = $form->createView();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('home_manager');
        }

        return $this->render('Front/Manager/editPlayer.html.twig', $params);
    }

    /**
     * Edition des stats joueurs
     *
     * @Route("/club/edit/{player}/{team}/details", name="front_player_details_edit")
     *
     * @param Request $request
     * @param Player $player
     * @param Team $team
     * @return RedirectResponse|Response
     */

    public function edit(Request $request, Player $player, Team $team): Response
    {
        $em = $this->getDoctrine()->getManager();

        $options['player'] = $player;
        $options['team'] = $team;

        if ($this->getDoctrine()->getRepository(PlayerDetails::class)->findByTeamAndPlayer($options) === null) {
            $playerDetails = new PlayerDetails();
        } else {
            $playerDetails = $this->getDoctrine()->getRepository(PlayerDetails::class)->findByTeamAndPlayer($options);
        }

        $form = $this->createForm(PlayerDetailsType::class, $playerDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playerDetails->setPlayer($player);
            $playerDetails->setTeam($team);
            $em->persist($playerDetails);
            $em->flush();

            $this->addFlash("success", "Stats mise à jour.");

            return $this->redirectToRoute('front_team_view', ['team' => $team->getId()]);
        }

        return $this->render('Front/Manager/editPlayerDetails.html.twig', [
            'team' => $team,
            'player' => $player,
            'playerDetails' => $playerDetails,
            'form' => $form->createView(),
        ]);
    }
}